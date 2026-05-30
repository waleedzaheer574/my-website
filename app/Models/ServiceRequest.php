<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
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
        'user_id',
        'full_name',
        'company_name',
        'company_website',
        'company_email',
        'phone_no',
        'country',
        'service_type',
        'status',
        'source',
        'budget',
        'requirement',
        'vapi_call_id',
        'call_status',
        'call_summary',
        'call_transcript',
        'raw_payload',
    ];

    protected $casts = [
        'raw_payload' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getServiceLabelAttribute(): string
    {
        if (app()->getLocale() !== 'ar') {
            return $this->service_type;
        }

        static $arabicServiceTitles;

        $arabicServiceTitles ??= Service::query()
            ->whereNotNull('service_title_ar')
            ->pluck('service_title_ar', 'service_title')
            ->all();

        return $arabicServiceTitles[$this->service_type] ?? $this->service_type;
    }

    public function getStatusLabelAttribute(): string
    {
        $key = "website.client.status_labels.{$this->status}";

        return __($key) !== $key ? __($key) : (self::STATUSES[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status)));
    }
}
