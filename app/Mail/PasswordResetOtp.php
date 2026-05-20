<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetOtp extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public User $user, public string $otp)
    {
    }

    public function build()
    {
        return $this->subject('Your Multitechwave password reset OTP')
            ->view('emails.password-reset-otp');
    }
}
