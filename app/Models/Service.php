<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, HasLocalizedContent;

    protected $fillable = [
        'icon',
        'service_title',
        'service_title_ar',
        'service_description',
        'service_description_ar',
        'order',
    ];

    public function detail()
    {
        return $this->hasOne(ServiceDetail::class);
    }
}
