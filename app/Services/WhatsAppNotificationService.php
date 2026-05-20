<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppNotificationService
{
    public function sendMessage(?string $phone, string $message): void
    {
        $token = config('services.whatsapp.token');
        $phoneNumberId = config('services.whatsapp.phone_number_id');

        if (! $phone || ! $token || ! $phoneNumberId) {
            return;
        }

        $recipient = preg_replace('/\D+/', '', $phone);

        if (! $recipient) {
            return;
        }

        try {
            Http::withToken($token)
                ->acceptJson()
                ->post(
                    rtrim(config('services.whatsapp.base_url'), '/').'/'.$phoneNumberId.'/messages',
                    [
                        'messaging_product' => 'whatsapp',
                        'recipient_type' => 'individual',
                        'to' => $recipient,
                        'type' => 'text',
                        'text' => [
                            'preview_url' => false,
                            'body' => $message,
                        ],
                    ]
                )
                ->throw();
        } catch (\Throwable $exception) {
            Log::warning('WhatsApp status update failed.', [
                'phone' => $recipient,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
