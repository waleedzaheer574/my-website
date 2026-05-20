<?php

namespace App\Http\Controllers;

use App\Mail\QuoteRequestSubmittedToClient;
use App\Mail\QuoteRequestSubmittedToCompany;
use App\Models\CompanySetting;
use App\Models\MailSetting;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Notifications\RequestStatusUpdatedNotification;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class QuoteRequestController extends Controller
{
    public function create()
    {
        $services = Service::with('detail')->orderBy('order')->latest()->get();
        $budgetOptions = $this->budgetOptions();
        $timelineOptions = $this->timelineOptions();

        return view('website.quote-generator', compact('services', 'budgetOptions', 'timelineOptions'));
    }

    public function store(Request $request, WhatsAppNotificationService $whatsApp)
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['required', 'email', 'max:255'],
            'client_phone' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'service_id' => ['required', 'exists:services,id'],
            'budget_range' => ['required', 'string', 'max:255'],
            'timeline' => ['nullable', 'string', 'max:255'],
            'requirements' => ['required', 'string', 'max:3000'],
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $estimate = $this->estimateFor($service->service_title, $validated['budget_range'], $validated['timeline'] ?? null);

        $quote = QuoteRequest::create([
            'public_token' => (string) Str::uuid(),
            'user_id' => $request->user()->id,
            'reference' => $this->nextReference(),
            'service_id' => $service->id,
            'service_title' => $service->service_title,
            'client_name' => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'client_phone' => $validated['client_phone'] ?? null,
            'company_name' => $validated['company_name'] ?? null,
            'budget_range' => $validated['budget_range'],
            'timeline' => $validated['timeline'] ?? null,
            'requirements' => $validated['requirements'],
            'currency' => 'USD',
            'estimated_min' => $estimate['min'],
            'estimated_max' => $estimate['max'],
            'deliverables' => $this->deliverablesFor($service->service_title),
            'assumptions' => $this->assumptionsFor($validated['budget_range'], $validated['timeline'] ?? null),
            'next_steps' => [
                'Review this instant estimate and proposal scope.',
                'Share brand assets, references, access, and any fixed deadline.',
                'Book a discovery call so Multitechwave can confirm the final quote and timeline.',
            ],
            'status' => 'submitted',
        ]);

        $this->sendQuoteEmails($quote);

        try {
            $submittedNotification = new RequestStatusUpdatedNotification(
                requestType: 'quote',
                requestTitle: $quote->service_title,
                event: 'submitted',
                reference: $quote->reference,
            );
            $proposalNotification = new RequestStatusUpdatedNotification(
                requestType: 'quote',
                requestTitle: $quote->service_title,
                event: 'proposal_sent',
                reference: $quote->reference,
                actionUrl: route('website.quote-generator.proposal', $quote->public_token),
            );
            $quote->user->notify($submittedNotification);
            $quote->user->notify($proposalNotification);
            $whatsApp->sendMessage($quote->client_phone, $submittedNotification->whatsappMessage());
            $whatsApp->sendMessage($quote->client_phone, $proposalNotification->whatsappMessage());
        } catch (\Throwable $exception) {
            report($exception);
        }

        return redirect()->route('website.quote-generator.proposal', [
            'token' => $quote->public_token,
            'submitted' => 1,
        ]);
    }

    public function show(string $token)
    {
        $quote = QuoteRequest::where('public_token', $token)->firstOrFail();
        $quote->forceFill(['viewed_at' => now()])->save();
        $companySetting = CompanySetting::latest()->first();

        return view('website.quote-result', compact('quote', 'companySetting'));
    }

    public function proposal(string $token)
    {
        $quote = QuoteRequest::where('public_token', $token)->firstOrFail();
        $companySetting = CompanySetting::latest()->first();

        return view('website.quote-proposal', compact('quote', 'companySetting'));
    }

    public function download(string $token)
    {
        $quote = QuoteRequest::where('public_token', $token)->firstOrFail();
        $pdf = $this->buildProposalPdf($quote);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$quote->reference.'-proposal.pdf"',
            'Content-Length' => strlen($pdf),
        ]);
    }

    public function index()
    {
        $quotes = QuoteRequest::latest()->paginate(15);
        $statuses = QuoteRequest::STATUSES;

        return view('dashboard.quotes.index', compact('quotes', 'statuses'));
    }

    public function dashboardShow(QuoteRequest $quote)
    {
        $statuses = QuoteRequest::STATUSES;

        return view('dashboard.quotes.show', compact('quote', 'statuses'));
    }

    public function updateStatus(Request $request, QuoteRequest $quote, WhatsAppNotificationService $whatsApp)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:'.implode(',', array_keys(QuoteRequest::STATUSES))],
        ]);

        $quote->update($validated);

        if ($quote->user) {
            try {
                $notification = new RequestStatusUpdatedNotification(
                    requestType: 'quote',
                    requestTitle: $quote->service_title,
                    event: $quote->status,
                    reference: $quote->reference,
                    actionUrl: $quote->status === 'proposal_sent'
                        ? route('website.quote-generator.proposal', $quote->public_token)
                        : route('user.dashboard'),
                );
                $quote->user->notify($notification);
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        $whatsApp->sendMessage(
            $quote->client_phone,
            ($notification ?? new RequestStatusUpdatedNotification(
                requestType: 'quote',
                requestTitle: $quote->service_title,
                event: $quote->status,
                reference: $quote->reference,
            ))->whatsappMessage()
        );

        return back()->with('success', 'Quote request status updated successfully.');
    }

    protected function budgetOptions(): array
    {
        return [
            'starter' => ['label' => '$500 - $1,500', 'min' => 500, 'max' => 1500],
            'growth' => ['label' => '$1,500 - $3,500', 'min' => 1500, 'max' => 3500],
            'scale' => ['label' => '$3,500 - $7,500', 'min' => 3500, 'max' => 7500],
            'enterprise' => ['label' => '$7,500+', 'min' => 7500, 'max' => 15000],
        ];
    }

    protected function timelineOptions(): array
    {
        return [
            'standard' => 'Flexible / Standard timeline',
            'fast' => 'Fast launch',
            'urgent' => 'Urgent priority delivery',
        ];
    }

    protected function estimateFor(string $serviceTitle, string $budgetRange, ?string $timeline): array
    {
        $budget = $this->budgetFromInput($budgetRange);
        $multiplier = 1.0;
        $title = Str::lower($serviceTitle);

        if (Str::contains($title, ['app', 'erp', 'crm', 'automation', 'cloud', 'saas'])) {
            $multiplier = 1.28;
        } elseif (Str::contains($title, ['seo', 'marketing', 'ads', 'social'])) {
            $multiplier = 0.88;
        } elseif (Str::contains($title, ['brand', 'graphic', 'video'])) {
            $multiplier = 0.78;
        }

        if ($timeline === 'fast') {
            $multiplier += 0.12;
        }

        if ($timeline === 'urgent') {
            $multiplier += 0.22;
        }

        return [
            'min' => (int) round($budget['min'] * $multiplier, -2),
            'max' => (int) round($budget['max'] * $multiplier, -2),
        ];
    }

    protected function deliverablesFor(string $serviceTitle): array
    {
        $title = Str::lower($serviceTitle);

        if (Str::contains($title, ['seo', 'marketing', 'ads', 'social'])) {
            return [
                'Discovery, audience, and competitor review',
                'Campaign strategy with channel priorities',
                'Tracking, reporting, and performance roadmap',
                'Optimization recommendations for growth',
            ];
        }

        if (Str::contains($title, ['app', 'erp', 'crm', 'automation', 'cloud', 'saas'])) {
            return [
                'Feature planning and user flow map',
                'UI/UX direction for the main screens',
                'Development scope for core modules',
                'Testing, launch support, and handover plan',
            ];
        }

        if (Str::contains($title, ['brand', 'graphic', 'video'])) {
            return [
                'Creative direction and style references',
                'Asset production plan',
                'Revision cycle and delivery formats',
                'Launch-ready brand or content package',
            ];
        }

        return [
            'Discovery and requirement mapping',
            'Responsive design direction',
            'Development or implementation scope',
            'Launch support and basic performance checks',
        ];
    }

    protected function assumptionsFor(string $budgetRange, ?string $timeline): array
    {
        $budgetLabel = $this->budgetOptions()[$budgetRange]['label'] ?? $budgetRange;
        $timelineLabel = $this->timelineOptions()[$timeline] ?? 'Standard timeline';

        return [
            "Budget selected by client: {$budgetLabel}.",
            "Timeline preference: {$timelineLabel}.",
            'Final pricing may change after technical discovery, integrations, content volume, and revision scope are confirmed.',
        ];
    }

    protected function nextReference(): string
    {
        return 'MTW-Q'.now()->format('ymd').'-'.str_pad((string) (QuoteRequest::count() + 1), 4, '0', STR_PAD_LEFT);
    }

    protected function sendQuoteEmails(QuoteRequest $quote): void
    {
        try {
            Mail::to($quote->client_email)->send(new QuoteRequestSubmittedToClient($quote));
        } catch (\Throwable $exception) {
            report($exception);
        }

        $notificationEmail = config('mail.service_request_notification_email')
            ?: MailSetting::latest()->value('notification_email')
            ?: CompanySetting::latest()->value('notification_email')
            ?: CompanySetting::latest()->value('email');

        if (! $notificationEmail) {
            return;
        }

        try {
            Mail::to($notificationEmail)->send(new QuoteRequestSubmittedToCompany($quote));
        } catch (\Throwable $exception) {
            report($exception);
        }
    }

    protected function budgetFromInput(string $budgetRange): array
    {
        if (isset($this->budgetOptions()[$budgetRange])) {
            return $this->budgetOptions()[$budgetRange];
        }

        preg_match_all('/\d[\d,]*/', $budgetRange, $matches);
        $amounts = collect($matches[0] ?? [])
            ->map(fn ($amount) => (int) str_replace(',', '', $amount))
            ->filter(fn ($amount) => $amount > 0)
            ->values();

        if ($amounts->count() >= 2) {
            return [
                'label' => $budgetRange,
                'min' => min($amounts[0], $amounts[1]),
                'max' => max($amounts[0], $amounts[1]),
            ];
        }

        if ($amounts->count() === 1) {
            return [
                'label' => $budgetRange,
                'min' => $amounts[0],
                'max' => $amounts[0],
            ];
        }

        return $this->budgetOptions()['growth'];
    }

    protected function buildProposalPdf(QuoteRequest $quote): string
    {
        $items = [
            [
                'type' => 'meta',
                'items' => [
                    ['Service', $quote->service_title],
                    ['Budget', $quote->budget_label],
                    ['Timeline', $quote->timeline_label],
                ],
            ],
            ['type' => 'section', 'text' => 'Requirements'],
        ];

        $items = array_merge($items, $this->pdfWrappedItems($quote->requirements, 'text'));
        $items[] = ['type' => 'section', 'text' => 'Included Deliverables'];

        foreach ($quote->deliverables ?? [] as $deliverable) {
            $items = array_merge($items, $this->pdfWrappedItems($deliverable, 'bullet'));
        }

        $items[] = ['type' => 'section', 'text' => 'Assumptions'];

        foreach ($quote->assumptions ?? [] as $assumption) {
            $items = array_merge($items, $this->pdfWrappedItems($assumption, 'bullet'));
        }

        $items[] = ['type' => 'section', 'text' => 'Next Steps'];

        foreach ($quote->next_steps ?? [] as $step) {
            $items = array_merge($items, $this->pdfWrappedItems($step, 'bullet'));
        }

        $pages = array_chunk($items, 24);
        $objects = [
            '1 0 obj'."\n".'<< /Type /Catalog /Pages 2 0 R >>'."\n".'endobj'."\n",
            '3 0 obj'."\n".'<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>'."\n".'endobj'."\n",
        ];
        $kids = [];
        $objectNumber = 4;

        foreach ($pages as $pageLines) {
            $pageObject = $objectNumber++;
            $contentObject = $objectNumber++;
            $kids[] = $pageObject.' 0 R';
            $stream = $this->pdfPageStream($pageLines, $quote, count($kids), count($pages));

            $objects[] = $pageObject.' 0 obj'."\n".'<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 3 0 R >> >> /Contents '.$contentObject.' 0 R >>'."\n".'endobj'."\n";
            $objects[] = $contentObject.' 0 obj'."\n".'<< /Length '.strlen($stream).' >>'."\n".'stream'."\n".$stream.'endstream'."\n".'endobj'."\n";
        }

        array_splice($objects, 1, 0, '2 0 obj'."\n".'<< /Type /Pages /Kids ['.implode(' ', $kids).'] /Count '.count($kids).' >>'."\n".'endobj'."\n");

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $xref = strlen($pdf);
        $pdf .= 'xref'."\n".'0 '.(count($objects) + 1)."\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= str_pad((string) $offsets[$i], 10, '0', STR_PAD_LEFT)." 00000 n \n";
        }

        $pdf .= 'trailer'."\n".'<< /Size '.(count($objects) + 1).' /Root 1 0 R >>'."\n";
        $pdf .= 'startxref'."\n".$xref."\n".'%%EOF';

        return $pdf;
    }

    protected function pdfPageStream(array $items, QuoteRequest $quote, int $pageNumber, int $pageCount): string
    {
        $stream = "";

        $stream .= "0.02 0.03 0.09 rg 0 0 612 792 re f\n";
        $stream .= "0.03 0.06 0.17 rg 34 34 544 724 re f\n";
        $stream .= "0.11 0.20 0.55 RG 34 34 544 724 re S\n";
        $stream .= "0.04 0.10 0.25 rg 382 548 164 150 re f\n";
        $stream .= "0.22 0.16 0.62 RG 382 548 164 150 re S\n";
        $stream .= "0.04 0.14 0.36 rg 404 686 122 18 re f\n";
        $stream .= "0.14 0.58 0.95 rg 414 662 58 58 re f\n";
        $stream .= $this->pdfTextAt('$', 437, 677, 28, 1, 1, 1);
        $stream .= $this->pdfTextAt('ESTIMATED INVESTMENT', 399, 632, 10, 0.72, 0.78, 0.92);
        $stream .= $this->pdfTextAt($quote->estimate_label, 407, 596, 24, 1, 1, 1);
        $stream .= "0.03 0.08 0.22 rg 408 566 112 22 re f\n";
        $stream .= $this->pdfTextAt($quote->budget_label, 428, 573, 10, 0.82, 0.9, 1);
        $stream .= $this->pdfTextAt('MULTITECHWAVE', 52, 728, 12, 0.22, 0.74, 0.97);
        $stream .= $this->pdfTextAt('TECHNOLOGY. INNOVATION. SOLUTIONS.', 52, 713, 7, 0.58, 0.68, 0.86);
        $stream .= $this->pdfTextAt('4D PROPOSAL UI', 52, 681, 10, 0.82, 0.9, 1);
        $stream .= $this->pdfTextAt('Premium', 52, 642, 28, 1, 1, 1);
        $stream .= $this->pdfTextAt('Project Proposal', 52, 608, 28, 1, 1, 1);
        $stream .= "0.14 0.58 0.95 rg 52 594 186 2 re f\n";
        $stream .= $this->pdfTextAt($quote->reference, 52, 566, 11, 0.82, 0.9, 1);
        $stream .= $this->pdfTextAt('Prepared for '.$quote->client_name.($quote->company_name ? ' at '.$quote->company_name : ''), 52, 546, 10, 0.72, 0.78, 0.92);
        $stream .= $this->pdfTextAt('Page '.$pageNumber.' / '.$pageCount, 494, 728, 10, 0.82, 0.9, 1);

        if ($pageNumber === 1) {
            $y = 468;
        } else {
            $stream .= "0.14 0.58 0.95 rg 52 626 508 2 re f\n";
            $y = 570;
        }

        foreach ($items as $item) {
            if ($item['type'] === 'meta') {
                $x = 52;

                foreach ($item['items'] as [$label, $value]) {
                    $stream .= "0.03 0.07 0.18 rg {$x} {$y} 154 66 re f\n";
                    $stream .= "0.14 0.32 0.74 RG {$x} {$y} 154 66 re S\n";
                    $stream .= $this->pdfTextAt($label, $x + 16, $y + 42, 9, 0.58, 0.68, 0.86);
                    $stream .= $this->pdfTextAt(Str::limit($value, 22, '...'), $x + 16, $y + 17, 12, 1, 1, 1);
                    $x += 176;
                }

                $y -= 92;
                continue;
            }

            if ($item['type'] === 'section') {
                $y -= 4;
                $stream .= "0.03 0.07 0.18 rg 52 ".($y - 10)." 508 34 re f\n";
                $stream .= "0.14 0.58 0.95 rg 52 ".($y - 10)." 8 34 re f\n";
                $stream .= $this->pdfTextAt($item['text'], 72, $y, 14, 1, 1, 1);
                $y -= 48;
                continue;
            }

            if ($item['type'] === 'bullet') {
                $stream .= "0.03 0.07 0.18 rg 52 ".($y - 9)." 508 24 re f\n";
                $stream .= "0.14 0.32 0.74 RG 52 ".($y - 9)." 508 24 re S\n";
                $stream .= "0.13 0.58 0.95 rg 66 ".($y - 1)." 7 7 re f\n";
                $stream .= $this->pdfTextAt($item['text'], 84, $y, 10, 0.82, 0.9, 1);
                $y -= 29;
                continue;
            }

            $stream .= "0.03 0.07 0.18 rg 52 ".($y - 9)." 508 24 re f\n";
            $stream .= $this->pdfTextAt($item['text'], 68, $y, 10, 0.82, 0.9, 1);
            $y -= 24;
        }

        $stream .= "0.02 0.03 0.09 rg 34 34 544 36 re f\n";
        $stream .= "0.14 0.58 0.95 rg 52 52 198 2 re f\n";
        $stream .= $this->pdfTextAt('Multitechwave - Technology, Innovation, Solutions', 52, 24, 9, 0.8, 0.9, 1);
        $stream .= $this->pdfTextAt('Generated Quote Proposal', 430, 24, 9, 0.8, 0.9, 1);

        return $stream;
    }

    protected function pdfWrappedItems(string $text, string $type = 'text', int $width = 86): array
    {
        $text = Str::of($text)->replace(["\r\n", "\r"], "\n")->explode("\n");
        $items = [];

        foreach ($text as $paragraph) {
            $wrapped = explode("\n", wordwrap((string) $paragraph, $width, "\n", true));

            foreach ($wrapped as $line) {
                $items[] = ['type' => $type, 'text' => $line];
            }
        }

        return $items;
    }

    protected function pdfTextAt(string $text, int $x, int $y, int $size, float $r, float $g, float $b): string
    {
        return "BT\n"
            .$r.' '.$g.' '.$b." rg\n"
            .'/F1 '.$size." Tf\n"
            .'1 0 0 1 '.$x.' '.$y." Tm\n"
            .'('.$this->pdfText($text).") Tj\n"
            ."ET\n";
    }

    protected function pdfText(string $text): string
    {
        $text = Str::ascii($text);

        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }
}
