<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'title',
        'slug',
        'category',
        'description',
        'detail_overview',
        'hero_visual_title',
        'currency',
        'price',
        'billing_cycle',
        'delivery_time',
        'features',
        'addons',
        'overview_items',
        'detail_features',
        'tech_stack',
        'delivery_timeline',
        'faqs',
        'why_choose',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'addons' => 'array',
        'overview_items' => 'array',
        'detail_features' => 'array',
        'tech_stack' => 'array',
        'delivery_timeline' => 'array',
        'faqs' => 'array',
        'why_choose' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function orders()
    {
        return $this->hasMany(OfferOrder::class);
    }

    public function getPriceLabelAttribute(): string
    {
        return $this->currency.' '.number_format($this->price);
    }

    public function getBillingLabelAttribute(): string
    {
        return match ($this->billing_cycle) {
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
            default => 'One-time',
        };
    }
}
