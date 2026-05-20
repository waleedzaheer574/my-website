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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }
}
