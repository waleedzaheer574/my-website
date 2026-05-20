<?php

namespace App\Http\Controllers;

use App\Models\AgencySubscription;
use App\Models\OfferOrder;

class AdminCommerceController extends Controller
{
    public function orders()
    {
        $orders = OfferOrder::with(['user', 'offer', 'subscription', 'project'])
            ->latest()
            ->paginate(15);

        return view('dashboard.orders.index', compact('orders'));
    }

    public function subscriptions()
    {
        $subscriptions = AgencySubscription::with(['user', 'offer', 'order'])
            ->latest()
            ->paginate(15);

        return view('dashboard.subscriptions.index', compact('subscriptions'));
    }
}
