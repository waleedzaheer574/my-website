<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            default => $this->budget_range ?: 'Custom budget',
        };
    }

    public function getTimelineLabelAttribute(): string
    {
        return match ($this->timeline) {
            'fast' => 'Fast launch',
            'urgent' => 'Urgent priority delivery',
            'standard' => 'Flexible / Standard timeline',
            default => $this->timeline ?: 'Standard',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }
}
