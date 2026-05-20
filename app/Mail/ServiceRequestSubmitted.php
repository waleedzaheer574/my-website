<?php

namespace App\Mail;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceRequestSubmitted extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public ServiceRequest $serviceRequest)
    {
    }

    public function build()
    {
        return $this->subject('New Service Request')
            ->view('emails.service-request-submitted');
    }
}
