<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencySubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'offer_id',
        'offer_order_id',
        'status',
        'billing_cycle',
        'amount',
        'currency',
        'starts_at',
        'renews_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'renews_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function order()
    {
        return $this->belongsTo(OfferOrder::class, 'offer_order_id');
    }
}
