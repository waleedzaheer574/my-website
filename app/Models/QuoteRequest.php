<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QuoteRequest extends Model
{
    use HasFactory;

    public const STATUSES = [
        'submitted' => 'Submitted',
        'pending_review' => 'Pending Review',
        'in_discussion' => 'In Discussion',
        'proposal_sent' => 'Proposal Sent',
        'deal_in_progress' => 'Deal In Progress',
        'approved' => 'Approved',
        'in_progress' => 'In Progress',
        'testing_review' => 'Testing & Review',
        'client_review' => 'Client Review',
        'completed' => 'Completed',
    ];

    protected $fillable = [
        'public_token',
        'user_id',
        'reference',
        'service_id',
        'service_title',
        'client_name',
        'client_email',
        'client_phone',
        'company_name',
        'budget_range',
        'timeline',
        'requirements',
        'currency',
        'estimated_min',
        'estimated_max',
        'deliverables',
        'assumptions',
        'next_steps',
        'status',
        'viewed_at',
    ];

    protected $casts = [
        'deliverables' => 'array',
        'assumptions' => 'array',
        'next_steps' => 'array',
        'viewed_at' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getServiceLabelAttribute(): string
    {
        return $this->service?->localized('service_title') ?: $this->service_title;
    }

    public function getEstimateLabelAttribute(): string
    {
        return $this->currency.' '.number_format($this->estimated_min).' - '.number_format($this->estimated_max);
    }

    public function getBudgetLabelAttribute(): string
    {
        return match ($this->budget_range) {
            'starter' => '$500 - $1,500',
            'growth' => '$1,500 - $3,500',
            'scale' => '$3,500 - $7,500',
            'enterprise' => '$7,500+',
            default => $this->budget_range ?: __('website.quote.custom_budget'),
        };
    }

    public function getTimelineLabelAttribute(): string
    {
        return match ($this->timeline) {
            'fast' => __('website.quote.timeline_options.fast'),
            'urgent' => __('website.quote.timeline_options.urgent'),
            'standard' => __('website.quote.timeline_options.standard'),
            default => $this->timeline ?: __('website.quote.timeline_options.default'),
        };
    }

    public function getLocalizedDeliverablesAttribute(): array
    {
        if (app()->getLocale() !== 'ar') {
            return $this->deliverables ?? [];
        }

        $title = Str::lower($this->service_title);
        $type = match (true) {
            Str::contains($title, ['seo', 'marketing', 'ads', 'social']) => 'marketing',
            Str::contains($title, ['app', 'erp', 'crm', 'automation', 'cloud', 'saas']) => 'software',
            Str::contains($title, ['brand', 'graphic', 'video']) => 'creative',
            default => 'standard',
        };

        return __('website.quote.generated.deliverables.'.$type);
    }

    public function getLocalizedAssumptionsAttribute(): array
    {
        if (app()->getLocale() !== 'ar') {
            return $this->assumptions ?? [];
        }

        return [
            __('website.quote.generated.assumptions.budget', ['budget' => $this->budget_label]),
            __('website.quote.generated.assumptions.timeline', ['timeline' => $this->timeline_label]),
            __('website.quote.generated.assumptions.final_price'),
        ];
    }

    public function getLocalizedNextStepsAttribute(): array
    {
        return app()->getLocale() === 'ar'
            ? __('website.quote.generated.next_steps')
            : ($this->next_steps ?? []);
    }

    public function getStatusLabelAttribute(): string
    {
        $key = "website.client.status_labels.{$this->status}";

        return __($key) !== $key ? __($key) : (self::STATUSES[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status)));
    }
}
