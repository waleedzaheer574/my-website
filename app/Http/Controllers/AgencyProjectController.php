<?php

namespace App\Http\Controllers;

use App\Models\AgencyProject;
use App\Models\AgencySubscription;
use App\Models\OfferOrder;
use App\Models\ProjectMessage;
use App\Models\QuoteRequest;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class AgencyProjectController extends Controller
{
    public function userIndex(Request $request)
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $projects = AgencyProject::with('order.offer')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('user.projects', [
            'projects' => $projects,
            ...$this->sidebarData($request->user()),
        ]);
    }

    public function userShow(Request $request, AgencyProject $project)
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        abort_unless($project->user_id === $request->user()->id, 403);
        $project->load(['milestones', 'messages.user', 'order.offer']);

        return view('user.project-show', [
            'project' => $project,
            ...$this->sidebarData($request->user()),
        ]);
    }

    public function userMessage(Request $request, AgencyProject $project)
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        abort_unless($project->user_id === $request->user()->id, 403);

        $data = $request->validate(['message' => ['required', 'string', 'max:2000']]);
        ProjectMessage::create($data + [
            'agency_project_id' => $project->id,
            'user_id' => $request->user()->id,
            'sender_type' => 'user',
        ]);

        return back()->with('success', 'Message added.');
    }

    public function adminIndex()
    {
        $projects = AgencyProject::with('user', 'order.offer')->latest()->paginate(15);

        return view('dashboard.projects.index', compact('projects'));
    }

    public function adminShow(AgencyProject $project)
    {
        $project->load(['user', 'milestones', 'messages.user', 'order.offer']);

        return view('dashboard.projects.show', compact('project'));
    }

    public function update(Request $request, AgencyProject $project)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,in_progress,review,revision,completed'],
            'progress' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        if ($data['status'] === 'completed') {
            $data['completed_at'] = now();
        }

        $project->update($data);

        return back()->with('success', 'Project updated.');
    }

    public function adminMessage(Request $request, AgencyProject $project)
    {
        $data = $request->validate(['message' => ['required', 'string', 'max:2000']]);
        ProjectMessage::create($data + [
            'agency_project_id' => $project->id,
            'user_id' => $request->user()->id,
            'sender_type' => 'admin',
        ]);

        return back()->with('success', 'Message sent.');
    }

    protected function sidebarData($user): array
    {
        return [
            'serviceRequestsCount' => ServiceRequest::where('user_id', $user->id)->count(),
            'quoteRequestsCount' => QuoteRequest::where('user_id', $user->id)->count(),
            'ordersCount' => OfferOrder::where('user_id', $user->id)->count(),
            'projectsCount' => AgencyProject::where('user_id', $user->id)->count(),
            'subscriptionsCount' => AgencySubscription::where('user_id', $user->id)->count(),
            'unreadNotificationsCount' => $user->unreadNotifications()->count(),
            'headerNotifications' => $user->notifications()->latest()->take(8)->get(),
        ];
    }
}
