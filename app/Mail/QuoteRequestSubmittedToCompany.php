<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteRequestSubmittedToCompany extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public QuoteRequest $quote)
    {
    }

    public function build()
    {
        return $this->subject('New quote request: '.$this->quote->reference)
            ->view('emails.quote-request-company');
    }
}
