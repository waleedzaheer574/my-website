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
use Illuminate\Support\Str;

class AiCallLeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
         

        $secret = config('services.vapi.webhook_secret');

        if ($secret && ! hash_equals($secret, (string) $request->bearerToken()) && ! hash_equals($secret, (string) $request->header('X-Vapi-Secret'))) {
            return response()->json([
                'ok' => false,
                'message' => 'Unauthorized webhook request.',
            ], 401);
        }

        $payload = $request->all();
        $data = $payload;

        foreach (['lead', 'customer', 'analysis', 'structuredData', 'message.analysis.structuredData', 'message.artifact', 'message.call.customer'] as $path) {
            $nested = data_get($payload, $path);

            if (is_array($nested)) {
                $data = array_merge($data, $nested);
            }
        }

        $validated = validator($data, [
            'full_name' => ['nullable', 'string', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_website' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'phone_no' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'service_type' => ['nullable', 'string', 'max:255'],
            'service' => ['nullable', 'string', 'max:255'],
            'budget' => ['nullable', 'string', 'max:255'],
            'requirement' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'summary' => ['nullable', 'string'],
            'transcript' => ['nullable', 'string'],
            'call_status' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:255'],
            'vapi_call_id' => ['nullable', 'string', 'max:255'],
            'call_id' => ['nullable', 'string', 'max:255'],
        ])->validate();

        $name = $validated['full_name'] ?? $validated['name'] ?? 'AI Call Visitor';
        $email = $validated['company_email'] ?? $validated['email'] ?? null;
        $phone = $validated['phone_no'] ?? $validated['phone'] ?? $validated['phone_number'] ?? $validated['number'] ?? null;
        $requirement = $validated['requirement'] ?? $validated['requirements'] ?? $validated['summary'] ?? null;
        $serviceType = $validated['service_type'] ?? $validated['service'] ?? 'AI Receptionist Lead';

       \Log::info('VAPI DEBUG', [
    'validated' => $validated,
    'email' => $email,
    'phone' => $phone,
]);

        if (! $email && ! $phone) {
            return response()->json([
                'ok' => false,
                'message' => 'Please provide at least customer email or phone.',
            ], 422);
        }

        $serviceRequest = ServiceRequest::create([
            'full_name' => $name,
            'company_name' => $validated['company_name'] ?? 'AI Call Lead',
            'company_website' => $validated['company_website'] ?? null,
            'company_email' => $email ?: 'unknown+'.Str::uuid().'@ai-call.local',
            'phone_no' => $phone ?: 'N/A',
            'country' => $validated['country'] ?? null,
            'service_type' => $serviceType,
            'status' => 'submitted',
            'source' => 'ai_call',
            'budget' => $validated['budget'] ?? null,
            'requirement' => $requirement,
            'vapi_call_id' => $validated['vapi_call_id'] ?? $validated['call_id'] ?? data_get($payload, 'call.id') ?? data_get($payload, 'message.call.id'),
            'call_status' => $validated['call_status'] ?? $validated['status'] ?? data_get($payload, 'message.type'),
            'call_summary' => $validated['summary'] ?? data_get($payload, 'summary') ?? data_get($payload, 'message.analysis.summary'),
            'call_transcript' => $validated['transcript'] ?? data_get($payload, 'transcript') ?? data_get($payload, 'message.artifact.transcript'),
            'raw_payload' => $payload,
        ]);

        $this->notifyAdmin($serviceRequest);

        return response()->json([
            'ok' => true,
            'message' => 'AI call lead saved successfully.',
            'lead_id' => $serviceRequest->id,
            'next_step' => 'Admin will contact the customer.',
        ], 201);
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
