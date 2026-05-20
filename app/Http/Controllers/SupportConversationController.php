<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use App\Models\AgencyProject;
use App\Models\AgencySubscription;
use App\Models\OfferOrder;
use App\Models\ServiceRequest;
use App\Models\SupportConversation;
use Illuminate\Http\Request;

class SupportConversationController extends Controller
{
    public function userShow(Request $request)
    {
        $conversation = SupportConversation::firstOrCreate(['user_id' => $request->user()->id]);
        $conversation->load(['messages.user']);

        return view('user.support-chat', [
            'conversation' => $conversation,
            'serviceRequestsCount' => ServiceRequest::where('user_id', $request->user()->id)->count(),
            'quoteRequestsCount' => QuoteRequest::where('user_id', $request->user()->id)->count(),
            'ordersCount' => OfferOrder::where('user_id', $request->user()->id)->count(),
            'projectsCount' => AgencyProject::where('user_id', $request->user()->id)->count(),
            'subscriptionsCount' => AgencySubscription::where('user_id', $request->user()->id)->count(),
            'unreadNotificationsCount' => $request->user()->unreadNotifications()->count(),
            'notifications' => $request->user()->notifications()->latest()->take(8)->get(),
            'headerNotifications' => $request->user()->notifications()->latest()->take(8)->get(),
            'recentRequests' => ServiceRequest::where('user_id', $request->user()->id)
                ->latest()
                ->take(4)
                ->get(),
        ]);
    }

    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $conversation = SupportConversation::firstOrCreate(['user_id' => $request->user()->id]);
        $conversation->messages()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);
        $conversation->update(['last_message_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json($this->messagePayload($conversation->messages()->with('user')->latest()->first()));
        }

        return back();
    }

    public function userMessages(Request $request)
    {
        $conversation = SupportConversation::firstOrCreate(['user_id' => $request->user()->id]);

        return response()->json([
            'messages' => $conversation->messages()
                ->with('user')
                ->when($request->integer('after'), fn ($query, int $after) => $query->where('id', '>', $after))
                ->oldest()
                ->get()
                ->map(fn ($message) => $this->messagePayload($message)),
        ]);
    }

    public function adminIndex()
    {
        $conversations = SupportConversation::with('user')
            ->withCount('messages')
            ->latest('last_message_at')
            ->paginate(20);
        $activeConversation = $conversations->first();
        $activeConversation?->load(['user', 'messages.user']);

        return view('dashboard.support.index', compact('conversations', 'activeConversation'));
    }

    public function adminShow(SupportConversation $conversation)
    {
        $conversation->load(['user', 'messages.user']);
        $conversations = SupportConversation::with('user')
            ->withCount('messages')
            ->latest('last_message_at')
            ->paginate(20);
        $activeConversation = $conversation;

        return view('dashboard.support.index', compact('conversations', 'activeConversation'));
    }

    public function adminStore(Request $request, SupportConversation $conversation)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $conversation->messages()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);
        $conversation->update(['last_message_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json($this->messagePayload($conversation->messages()->with('user')->latest()->first()));
        }

        return back();
    }

    public function adminMessages(Request $request, SupportConversation $conversation)
    {
        return response()->json([
            'messages' => $conversation->messages()
                ->with('user')
                ->when($request->integer('after'), fn ($query, int $after) => $query->where('id', '>', $after))
                ->oldest()
                ->get()
                ->map(fn ($message) => $this->messagePayload($message)),
        ]);
    }

    protected function messagePayload($message): array
    {
        return [
            'id' => $message->id,
            'user_id' => $message->user_id,
            'user_name' => $message->user->name,
            'is_admin' => $message->user->isAdmin(),
            'body' => $message->body,
            'time' => $message->created_at->format('h:i A'),
            'date' => $message->created_at->format('M d, Y'),
        ];
    }
}
