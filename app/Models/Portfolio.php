<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'title',
        'title_ar',
        'slug',
        'category',
        'category_ar',
        'client',
        'tags',
        'tags_ar',
        'duration',
        'duration_ar',
        'demo_url',
        'image',
        'secondary_image',
        'detail_image',
        'short_description',
        'short_description_ar',
        'description',
        'description_ar',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
}
