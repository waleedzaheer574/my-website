<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'service_title',
        'service_description',
        'order',
    ];

    public function detail()
    {
        return $this->hasOne(ServiceDetail::class);
    }
}
