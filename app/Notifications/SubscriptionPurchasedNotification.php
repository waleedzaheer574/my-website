<?php

namespace App\Notifications;

use App\Models\AgencySubscription;
use App\Models\OfferOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubscriptionPurchasedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected OfferOrder $order,
        protected AgencySubscription $subscription
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $offerTitle = $this->order->offer?->title
            ?: $this->subscription->offer?->title
            ?: 'Subscription';

        return [
            'type' => 'subscription_paid',
            'icon' => 'fas fa-check-circle',
            'title' => 'Subscription activated',
            'message' => $offerTitle.' is active. Payment '.$this->order->amount_label.' received.',
            'status' => 'active',
            'action_url' => route('user.subscriptions'),
        ];
    }
}
