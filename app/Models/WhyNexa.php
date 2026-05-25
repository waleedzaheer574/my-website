<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

class WhyNexa extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'title',
        'title_ar',
        'description',
        'description_ar',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
