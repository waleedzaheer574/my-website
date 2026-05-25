<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'client_name',
        'designation',
        'designation_ar',
        'badge',
        'badge_ar',
        'rating',
        'review_text',
        'review_text_ar',
        'media_path',
        'media_type',
        'poster_path',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'integer',
        'sort_order' => 'integer',
    ];
}
