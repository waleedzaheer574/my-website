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
        $source = $this->serviceRequest->source === 'ai_call' ? 'AI Call Lead' : 'Service Request';

        return $this->subject('New '.$source)
            ->view('emails.service-request-submitted');
    }
}
