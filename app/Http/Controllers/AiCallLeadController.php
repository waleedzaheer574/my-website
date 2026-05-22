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
use Illuminate\Support\Str;

class AiCallLeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
            return response()->json([
        'received' => $request->all()
    ]);

        \Log::info('VAPI REQUEST RECEIVED', $request->all());
        $payload = $request->all();

        Log::info('VAPI REQUEST RECEIVED', [
            'payload' => $payload,
            'has_bearer_token' => filled($request->bearerToken()),
            'has_x_vapi_secret' => filled($request->header('X-Vapi-Secret')),
            'ip' => $request->ip(),
        ]);

        $secret = config('services.vapi.webhook_secret');

        if ($secret && ! hash_equals($secret, (string) $request->bearerToken()) && ! hash_equals($secret, (string) $request->header('X-Vapi-Secret'))) {
            return response()->json([
                'ok' => false,
                'message' => 'Unauthorized webhook request.',
            ], 401);
        }

        $data = $this->flattenLeadPayload($payload);
        $data = $this->normalizeLeadEmail($data);
        $validator = Validator::make($data, [
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
        ]);

        if ($validator->fails()) {
            Log::warning('INVALID VAPI DATA', [
                'errors' => $validator->errors()->toArray(),
                'payload' => $payload,
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Invalid lead data.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $name = $this->firstFilled($validated, ['full_name', 'name']) ?: 'AI Call Visitor';
        $email = $this->firstFilled($validated, ['company_email', 'email']);
        $phone = $this->firstFilled($validated, ['phone_no', 'phone', 'phone_number', 'number']);
        $requirement = $this->firstFilled($validated, ['requirement', 'requirements', 'summary']);
        $serviceType = $this->firstFilled($validated, ['service_type', 'service']) ?: 'AI Receptionist Lead';
        $vapiCallId = $this->firstFilled($validated, ['vapi_call_id', 'call_id'])
            ?: data_get($payload, 'call.id')
            ?: data_get($payload, 'message.call.id');
        $callStatus = $this->firstFilled($validated, ['call_status', 'status'])
            ?: data_get($payload, 'message.type');
        $callSummary = $validated['summary']
            ?? data_get($payload, 'summary')
            ?? data_get($payload, 'message.analysis.summary');
        $callTranscript = $validated['transcript']
            ?? data_get($payload, 'transcript')
            ?? data_get($payload, 'message.artifact.transcript');

        Log::info('VALIDATED VAPI DATA', [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'service' => $serviceType,
            'vapi_call_id' => $vapiCallId,
        ]);

        Log::info('VAPI DEBUG', [
            'request' => $request->all(),
            'validated' => $validated,
            'email' => $email,
            'phone' => $phone,
        ]);

        if (! $email && ! $phone) {
            Log::warning('VAPI LEAD MISSING CONTACT', [
                'payload' => $payload,
            ]);

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
            'vapi_call_id' => $vapiCallId,
            'call_status' => $callStatus,
            'call_summary' => $callSummary,
            'call_transcript' => $callTranscript,
            'raw_payload' => $payload,
        ]);

        Log::info('VAPI LEAD SAVED', [
            'lead_id' => $serviceRequest->id,
            'vapi_call_id' => $serviceRequest->vapi_call_id,
        ]);

        $this->notifyAdmin($serviceRequest);

        return response()->json([
            'ok' => true,
            'message' => 'AI call lead saved successfully.',
            'lead_id' => $serviceRequest->id,
            'next_step' => 'Admin will contact the customer.',
        ], 201);
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
