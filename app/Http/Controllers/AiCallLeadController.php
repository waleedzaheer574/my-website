<?php

namespace App\Http\Controllers;

use App\Mail\ServiceRequestSubmitted;
use App\Models\CompanySetting;
use App\Models\MailSetting;
use App\Models\ServiceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AiCallLeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        return response()->json([
    'received' => $request->all()
]);
    }

    protected function flattenLeadPayload(array $payload): array
    {
        $data = $payload;

        foreach ($this->leadPayloadPaths() as $path) {
            $nested = data_get($payload, $path);

            if (is_array($nested)) {
                $data = array_merge($data, $nested);
            }
        }

        return $data;
    }

    protected function normalizeLeadEmail(array $data): array
    {
        foreach (['email', 'company_email'] as $key) {
            if (empty($data[$key]) || ! is_string($data[$key])) {
                continue;
            }

            $data[$key] = strtolower($data[$key]);
            $data[$key] = str_replace(
                [' at ', ' dot ', 'g mail'],
                ['@', '.', 'gmail'],
                $data[$key]
            );
        }

        return $data;
    }

    protected function leadPayloadPaths(): array
    {
        return [
            'lead',
            'customer',
            'analysis',
            'structuredData',
            'message.analysis.structuredData',
            'message.artifact',
            'message.artifact.messages.0',
            'message.call.customer',
            'call.customer',
        ];
    }

    protected function firstFilled(array $data, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = $data[$key] ?? null;

            if (filled($value)) {
                return (string) $value;
            }
        }

        return null;
    }

    protected function notifyAdmin(ServiceRequest $serviceRequest): void
    {
        $notificationEmail = config('mail.service_request_notification_email')
            ?: MailSetting::latest()->value('notification_email')
            ?: CompanySetting::latest()->value('notification_email')
            ?: CompanySetting::latest()->value('email');

        if (! $notificationEmail) {
            return;
        }

        try {
            Mail::to($notificationEmail)->send(new ServiceRequestSubmitted($serviceRequest));
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}
