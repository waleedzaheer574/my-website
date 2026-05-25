<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'title',
        'title_ar',
        'slug',
        'author_name',
        'category',
        'category_ar',
        'author_image',
        'featured_image',
        'excerpt',
        'excerpt_ar',
        'content',
        'content_ar',
        'author_bio',
        'author_bio_ar',
        'views',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
