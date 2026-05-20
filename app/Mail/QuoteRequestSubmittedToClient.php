<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteRequestSubmittedToClient extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public QuoteRequest $quote)
    {
    }

    public function build()
    {
        return $this->subject('Your Multitechwave quote request has been received')
            ->view('emails.quote-request-client');
    }
}
