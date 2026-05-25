<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory, HasLocalizedContent;

    protected $fillable = [
        'service_id',
        'slug',
        'title_prefix',
        'title_prefix_ar',
        'title_highlight',
        'title_highlight_ar',
        'description',
        'description_ar',
        'process_heading',
        'process_heading_ar',
        'process_one_title',
        'process_one_title_ar',
        'process_one_text',
        'process_one_text_ar',
        'process_two_title',
        'process_two_title_ar',
        'process_two_text',
        'process_two_text_ar',
        'process_three_title',
        'process_three_title_ar',
        'process_three_text',
        'process_three_text_ar',
        'primary_image',
        'video_thumbnail',
        'video_url',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
