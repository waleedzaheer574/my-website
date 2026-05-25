<?php

namespace App\Http\Controllers;

use App\Models\AgencyProject;
use App\Models\AgencySubscription;
use App\Models\Offer;
use App\Models\OfferOrder;
use App\Models\ProjectMilestone;
use App\Notifications\SubscriptionPurchasedNotification;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function create(Offer $offer)
    {
        abort_unless($offer->is_active, 404);

        return view('website.checkout', compact('offer'));
    }

    public function store(Request $request, Offer $offer)
    {
        abort_unless($offer->is_active, 404);

        $data = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['required', 'email', 'max:255'],
            'client_phone' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'payment_method' => ['required', 'in:stripe,paypal,credit_card'],
            'coupon_code' => ['nullable', 'string', 'max:80'],
            'addons' => ['nullable', 'array'],
            'addons.*' => ['string', 'max:80'],
            'requirements' => ['nullable', 'string', 'max:3000'],
        ]);

        $addonPrices = [
            'extra_pages' => 200,
            'seo_optimization' => 150,
            'premium_design' => 200,
            'content_writing' => 100,
        ];
        $selectedAddons = collect($data['addons'] ?? [])
            ->filter(fn ($addon) => array_key_exists($addon, $addonPrices))
            ->values();
        $addonTotal = $selectedAddons->sum(fn ($addon) => $addonPrices[$addon]);

        $order = OfferOrder::create(array_merge($data, [
            'reference' => $this->nextReference(),
            'user_id' => $request->user()->id,
            'offer_id' => $offer->id,
            'currency' => $offer->currency,
            'amount' => $offer->price + $addonTotal,
            'payment_status' => 'paid',
            'status' => 'paid',
            'addons' => $selectedAddons->all(),
            'paid_at' => now(),
        ]));

        $subscription = AgencySubscription::create([
            'user_id' => $request->user()->id,
            'offer_id' => $offer->id,
            'offer_order_id' => $order->id,
            'status' => 'active',
            'billing_cycle' => $offer->billing_cycle,
            'amount' => $offer->price + $addonTotal,
            'currency' => $offer->currency,
            'starts_at' => now(),
            'renews_at' => $offer->billing_cycle === 'monthly' ? now()->addMonth() : ($offer->billing_cycle === 'yearly' ? now()->addYear() : null),
        ]);

        $project = AgencyProject::create([
            'user_id' => $request->user()->id,
            'offer_order_id' => $order->id,
            'title' => $offer->title,
            'description' => $data['requirements'] ?? $offer->description,
            'status' => 'in_progress',
            'progress' => 15,
            'starts_at' => now(),
            'due_at' => now()->addWeeks(2),
        ]);

        foreach (['Requirements', 'Design & planning', 'Development', 'Review', 'Delivery'] as $index => $milestone) {
            ProjectMilestone::create([
                'agency_project_id' => $project->id,
                'title' => $milestone,
                'status' => $index === 0 ? 'in_progress' : 'pending',
            ]);
        }

        $request->user()->notify(new SubscriptionPurchasedNotification($order, $subscription));

        return redirect()->route('user.orders')->with([
            'success' => __('website.checkout.success'),
            'subscription_success' => true,
            'subscription_title' => $offer->localized('title'),
            'subscription_amount' => $order->amount_label,
        ]);
    }

    protected function nextReference(): string
    {
        return 'ORD-'.now()->format('ymd').'-'.str_pad((string) (OfferOrder::count() + 1), 4, '0', STR_PAD_LEFT);
    }
}
