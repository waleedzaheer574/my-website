<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'slug',
        'title_prefix',
        'title_highlight',
        'description',
        'process_heading',
        'process_one_title',
        'process_one_text',
        'process_two_title',
        'process_two_text',
        'process_three_title',
        'process_three_text',
        'primary_image',
        'video_thumbnail',
        'video_url',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
