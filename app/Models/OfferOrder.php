<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferOrder extends Model
{
    use HasFactory;

    public const STATUSES = [
        'submitted' => 'Submitted',
        'payment_pending' => 'Payment Pending',
        'paid' => 'Paid',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    protected $fillable = [
        'reference',
        'user_id',
        'offer_id',
        'client_name',
        'client_email',
        'client_phone',
        'company_name',
        'currency',
        'amount',
        'payment_method',
        'payment_status',
        'status',
        'coupon_code',
        'addons',
        'requirements',
        'paid_at',
    ];

    protected $casts = [
        'addons' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function project()
    {
        return $this->hasOne(AgencyProject::class);
    }

    public function subscription()
    {
        return $this->hasOne(AgencySubscription::class);
    }

    public function getAmountLabelAttribute(): string
    {
        return $this->currency.' '.number_format($this->amount);
    }

    public function getStatusLabelAttribute(): string
    {
        $key = "website.client.status_labels.{$this->status}";

        return __($key) !== $key ? __($key) : (self::STATUSES[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status)));
    }
}
