<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'logo',
        'phone',
        'whatsapp_number',
        'quote_link',
        'fax',
        'address',
        'email',
        'smtp_email',
        'smtp_password',
        'notification_email',
        'instagram',
        'pinterest',
        'facebook',
        'youtube',
        'tiktok',
        'linkedin',
        'theme_primary_color',
        'theme_secondary_color',
        'theme_dark_color',
    ];

    protected $casts = [
        'smtp_password' => 'encrypted',
    ];
}
