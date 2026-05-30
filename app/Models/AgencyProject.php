<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyProject extends Model
{
    use HasFactory;

    public const STATUSES = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'review' => 'Review',
        'revision' => 'Revision',
        'completed' => 'Completed',
    ];

    protected $fillable = [
        'user_id',
        'offer_order_id',
        'quote_request_id',
        'service_request_id',
        'title',
        'description',
        'status',
        'progress',
        'starts_at',
        'due_at',
        'completed_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'due_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(OfferOrder::class, 'offer_order_id');
    }

    public function getTitleLabelAttribute(): string
    {
        return $this->order?->offer?->localized('title') ?: $this->title;
    }

    public function getDescriptionLabelAttribute(): ?string
    {
        $offer = $this->order?->offer;

        if ($offer && $this->description === $offer->description) {
            return $offer->localized('description');
        }

        return $this->description;
    }

    public function milestones()
    {
        return $this->hasMany(ProjectMilestone::class);
    }

    public function messages()
    {
        return $this->hasMany(ProjectMessage::class);
    }

    public function getStatusLabelAttribute(): string
    {
        $key = "website.client.status_labels.{$this->status}";

        return __($key) !== $key ? __($key) : (self::STATUSES[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status)));
    }
}
