<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NewsletterSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validateWithBag('newsletter', [
            'email' => ['required', 'email', 'max:255'],
        ]);

        $subscription = NewsletterSubscription::firstOrCreate(
            ['email' => strtolower($validated['email'])],
            ['source_url' => url()->previous()]
        );

        $message = $subscription->wasRecentlyCreated
            ? __('website.footer.subscribed')
            : __('website.footer.already_subscribed');

        return back()->with('newsletter_success', $message);
    }

    public function index()
    {
        $subscriptions = NewsletterSubscription::latest()->paginate(20);

        return view('dashboard.newsletter-subscriptions.index', compact('subscriptions'));
    }

    public function download(): StreamedResponse
    {
        $fileName = 'newsletter-subscriptions-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', 'Email', 'Source URL', 'Subscribed At']);

            NewsletterSubscription::orderBy('created_at')->chunk(200, function ($subscriptions) use ($handle) {
                foreach ($subscriptions as $subscription) {
                    fputcsv($handle, [
                        $subscription->id,
                        $subscription->email,
                        $subscription->source_url,
                        optional($subscription->created_at)->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
