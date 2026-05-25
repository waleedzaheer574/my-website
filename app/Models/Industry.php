<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'title',
        'title_ar',
        'slug',
        'category',
        'category_ar',
        'icon',
        'description',
        'description_ar',
        'result',
        'result_ar',
        'cta_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
