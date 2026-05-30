<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory, HasLocalizedContent;

    protected $fillable = [
        'service_id',
        'title',
        'title_ar',
        'slug',
        'category',
        'category_ar',
        'description',
        'description_ar',
        'detail_overview',
        'detail_overview_ar',
        'hero_visual_title',
        'hero_visual_title_ar',
        'currency',
        'price',
        'billing_cycle',
        'delivery_time',
        'features',
        'features_ar',
        'addons',
        'overview_items',
        'overview_items_ar',
        'detail_features',
        'detail_features_ar',
        'tech_stack',
        'delivery_timeline',
        'delivery_timeline_ar',
        'faqs',
        'faqs_ar',
        'why_choose',
        'why_choose_ar',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'features_ar' => 'array',
        'addons' => 'array',
        'overview_items' => 'array',
        'overview_items_ar' => 'array',
        'detail_features' => 'array',
        'detail_features_ar' => 'array',
        'tech_stack' => 'array',
        'delivery_timeline' => 'array',
        'delivery_timeline_ar' => 'array',
        'faqs' => 'array',
        'faqs_ar' => 'array',
        'why_choose' => 'array',
        'why_choose_ar' => 'array',
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
            'monthly' => __('website.dynamic.billing.monthly'),
            'yearly' => __('website.dynamic.billing.yearly'),
            default => __('website.dynamic.billing.one_time'),
        };
    }

    public function getDeliveryLabelAttribute(): ?string
    {
        if (! filled($this->delivery_time) || app()->getLocale() !== 'ar') {
            return $this->delivery_time;
        }

        $delivery = trim($this->delivery_time);

        if (preg_match('/^(\d+)\s*-\s*(\d+)\s*days?$/i', $delivery, $matches)) {
            return __('website.dynamic.delivery.days_range', ['from' => $matches[1], 'to' => $matches[2]]);
        }

        if (preg_match('/^(\d+)\s*-\s*(\d+)\s*weeks?$/i', $delivery, $matches)) {
            return __('website.dynamic.delivery.weeks_range', ['from' => $matches[1], 'to' => $matches[2]]);
        }

        if (preg_match('/^(\d+)\s*days?$/i', $delivery, $matches)) {
            return __('website.dynamic.delivery.days', ['count' => $matches[1]]);
        }

        if (preg_match('/^(\d+)\s*weeks?$/i', $delivery, $matches)) {
            return __('website.dynamic.delivery.weeks', ['count' => $matches[1]]);
        }

        return strtolower($delivery) === 'monthly'
            ? __('website.dynamic.delivery.monthly')
            : $delivery;
    }
}
