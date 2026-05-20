<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    public function pricing()
    {
        $offers = Offer::with('service')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->get();

        if ($offers->isEmpty()) {
            $offers = $this->defaultOffers();
        }

        return view('website.offers', compact('offers'));
    }

    public function show(?Offer $offer = null)
    {
        $offer ??= Offer::where('is_active', true)->orderBy('sort_order')->latest()->first();
        abort_unless($offer, 404);
        abort_unless($offer->is_active, 404);

        $relatedOffers = Offer::where('is_active', true)
            ->where('id', '!=', $offer->id)
            ->orderBy('sort_order')
            ->latest()
            ->take(3)
            ->get();

        return view('website.offer-details', compact('offer', 'relatedOffers'));
    }

    public function adminIndex()
    {
        $offers = Offer::with('service')->latest()->paginate(15);

        return view('dashboard.offers.index', compact('offers'));
    }

    public function create()
    {
        return view('dashboard.offers.create', [
            'offer' => null,
            'services' => Service::orderBy('order')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data = $this->attachDynamicContent($request, $data);

        Offer::create($data);

        return redirect()->route('offers.admin.index')->with('success', 'Offer created successfully.');
    }

    public function edit(Offer $offer)
    {
        return view('dashboard.offers.edit', [
            'offer' => $offer,
            'services' => Service::orderBy('order')->latest()->get(),
        ]);
    }

    public function update(Request $request, Offer $offer)
    {
        $data = $this->validated($request);
        $data['slug'] = $request->filled('slug') ? $this->uniqueSlug($request->input('slug'), $offer->id) : $this->uniqueSlug($data['title'], $offer->id);
        $data = $this->attachDynamicContent($request, $data);

        $offer->update($data);

        return redirect()->route('offers.admin.index')->with('success', 'Offer updated successfully.');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();

        return redirect()->route('offers.admin.index')->with('success', 'Offer deleted successfully.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'service_id' => ['nullable', 'exists:services,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'detail_overview' => ['nullable', 'string'],
            'hero_visual_title' => ['nullable', 'string', 'max:255'],
            'currency' => ['required', 'string', 'max:8'],
            'price' => ['required', 'integer', 'min:0'],
            'billing_cycle' => ['required', 'in:one_time,monthly,yearly'],
            'delivery_time' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    protected function attachDynamicContent(Request $request, array $data): array
    {
        $data['features'] = $this->linesToArray($request->input('features_text'));
        $data['addons'] = $this->linesToArray($request->input('addons_text'));
        $data['overview_items'] = $this->linesToArray($request->input('overview_items_text'));
        $data['detail_features'] = $this->pairedLinesToArray($request->input('detail_features_text'), 'title', 'description');
        $data['tech_stack'] = $this->linesToArray($request->input('tech_stack_text'));
        $data['delivery_timeline'] = $this->pairedLinesToArray($request->input('delivery_timeline_text'), 'title', 'description');
        $data['faqs'] = $this->pairedLinesToArray($request->input('faqs_text'), 'question', 'answer');
        $data['why_choose'] = $this->linesToArray($request->input('why_choose_text'));
        $data['is_popular'] = $request->boolean('is_popular');
        $data['is_active'] = $request->boolean('is_active', true);

        return $data;
    }

    protected function linesToArray(?string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    protected function pairedLinesToArray(?string $value, string $firstKey, string $secondKey): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->map(function (string $line) use ($firstKey, $secondKey) {
                [$first, $second] = array_pad(array_map('trim', explode('|', $line, 2)), 2, '');

                return [
                    $firstKey => $first,
                    $secondKey => $second,
                ];
            })
            ->filter(fn ($item) => $item[$firstKey] !== '')
            ->values()
            ->all();
    }

    protected function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value) ?: Str::random(8);
        $slug = $base;
        $i = 2;

        while (Offer::where('slug', $slug)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    protected function defaultOffers()
    {
        return collect([
            new Offer([
                'title' => '5 Page Dynamic Website',
                'slug' => '5-page-dynamic-website',
                'category' => 'Website Development',
                'description' => 'Fast, premium business website with service pages and contact flow.',
                'currency' => 'AED',
                'price' => 200,
                'billing_cycle' => 'one_time',
                'delivery_time' => '5 - 7 days',
                'features' => ['Responsive pages', 'Admin editable content', 'Contact form', 'Basic SEO setup'],
                'is_popular' => true,
                'is_active' => true,
            ]),
            new Offer([
                'title' => 'Ecommerce Website',
                'slug' => 'ecommerce-website',
                'category' => 'Online Store',
                'description' => 'Conversion-focused ecommerce storefront with product and checkout flow.',
                'currency' => 'AED',
                'price' => 1200,
                'billing_cycle' => 'one_time',
                'delivery_time' => '2 - 3 weeks',
                'features' => ['Product catalog', 'Cart and checkout', 'Payment-ready UI', 'Order dashboard'],
                'is_active' => true,
            ]),
            new Offer([
                'title' => 'SEO Starter Package',
                'slug' => 'seo-starter-package',
                'category' => 'SEO Services',
                'description' => 'Starter SEO package for improving visibility and technical basics.',
                'currency' => 'AED',
                'price' => 150,
                'billing_cycle' => 'monthly',
                'delivery_time' => 'Monthly',
                'features' => ['Keyword plan', 'On-page SEO', 'Technical checks', 'Monthly report'],
                'is_active' => true,
            ]),
            new Offer([
                'title' => 'Laravel SaaS System',
                'slug' => 'laravel-saas-system',
                'category' => 'SaaS Development',
                'description' => 'Custom Laravel SaaS platform with auth, dashboard, roles and workflows.',
                'currency' => 'AED',
                'price' => 3000,
                'billing_cycle' => 'one_time',
                'delivery_time' => '4 - 8 weeks',
                'features' => ['Laravel backend', 'User dashboard', 'Admin panel', 'Project workflow'],
                'is_active' => true,
            ]),
            new Offer([
                'title' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'category' => 'Mobile Apps',
                'description' => 'Android and iOS mobile app development with API integrations and admin control.',
                'currency' => 'AED',
                'price' => 800,
                'billing_cycle' => 'one_time',
                'delivery_time' => '20 days',
                'features' => ['Cross platform', 'Modern UI/UX', 'API integrations', 'Admin panel', '2 revisions'],
                'is_active' => true,
            ]),
        ]);
    }
}
