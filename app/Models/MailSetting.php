<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    protected $fillable = [
        'sender_email',
        'sender_password',
        'notification_email',
    ];

    protected $casts = [
        'sender_password' => 'encrypted',
    ];
}
