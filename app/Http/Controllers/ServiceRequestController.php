<?php

namespace App\Http\Controllers;

use App\Mail\ServiceRequestSubmitted;
use App\Models\CompanySetting;
use App\Models\MailSetting;
use App\Models\ServiceRequest;
use App\Notifications\RequestStatusUpdatedNotification;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $serviceRequests = ServiceRequest::latest()->paginate(15);
        $statuses = ServiceRequest::STATUSES;

        return view('dashboard.requests.index', compact('serviceRequests', 'statuses'));
    }

    public function store(Request $request, WhatsAppNotificationService $whatsApp)
    {
        if (! $request->user()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Please login or create an account before submitting a request.',
                    'redirect' => route('login'),
                ], 401);
            }

            return redirect()->route('login')->with('status', 'Please login or create an account before submitting a request.');
        }

        if (! $request->user()->isAdmin() && ! $request->user()->hasVerifiedEmail()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Please complete the one-time email verification for your new account.',
                    'redirect' => route('verification.notice'),
                ], 403);
            }

            return redirect()->route('verification.notice')->with('status', 'Please complete the one-time email verification for your new account.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_website' => 'nullable|string|max:255',
            'company_email' => 'required|email|max:255',
            'phone_no' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'service_type' => 'required|string|max:255',
        ]);

        $serviceRequest = ServiceRequest::create($validated + [
            'user_id' => $request->user()->id,
            'status' => 'submitted',
        ]);
        $notificationEmail = config('mail.service_request_notification_email')
            ?: MailSetting::latest()->value('notification_email')
            ?: CompanySetting::latest()->value('notification_email');

        if ($notificationEmail) {
            try {
                Mail::to($notificationEmail)->send(new ServiceRequestSubmitted($serviceRequest));
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        try {
            $notification = new RequestStatusUpdatedNotification(
                requestType: 'service',
                requestTitle: $serviceRequest->service_type,
                event: 'submitted',
            );
            $serviceRequest->user->notify($notification);
            $whatsApp->sendMessage($serviceRequest->phone_no, $notification->whatsappMessage());
        } catch (\Throwable $exception) {
            report($exception);
        }

        $message = 'Your request has been submitted successfully.';

        if ($request->expectsJson()) {
            return response()->json(compact('message'), 201);
        }

        return back()->with('success', $message);
    }

    public function updateStatus(Request $request, ServiceRequest $serviceRequest, WhatsAppNotificationService $whatsApp)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:'.implode(',', array_keys(ServiceRequest::STATUSES))],
        ]);

        $serviceRequest->update($validated);

        if ($serviceRequest->user) {
            try {
                $notification = new RequestStatusUpdatedNotification(
                    requestType: 'service',
                    requestTitle: $serviceRequest->service_type,
                    event: $serviceRequest->status,
                );
                $serviceRequest->user->notify($notification);
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        $whatsApp->sendMessage(
            $serviceRequest->phone_no,
            ($notification ?? new RequestStatusUpdatedNotification(
                requestType: 'service',
                requestTitle: $serviceRequest->service_type,
                event: $serviceRequest->status,
            ))->whatsappMessage()
        );

        return back()->with('success', 'Service request status updated successfully.');
    }
}
