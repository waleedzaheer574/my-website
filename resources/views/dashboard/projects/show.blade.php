@extends('layouts.admin')

@section('header')
  <h2 class="admin-u-001">{{ $project->title_label }}</h2>
@endsection

@section('content')
<div class="admin-project-grid">
  <div class="card">
    <h3>Project Status</h3>
    <form action="{{ route('projects.admin.update', $project) }}" method="POST">
      @csrf @method('PATCH')
      <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
          @foreach(\App\Models\AgencyProject::STATUSES as $value => $label)
            <option value="{{ $value }}" @selected($project->status === $value)>{{ __('website.client.status_labels.'.$value) }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Progress</label>
        <input type="number" name="progress" min="0" max="100" class="form-control" value="{{ $project->progress }}">
      </div>
      <button class="btn btn-primary">Update Project</button>
    </form>
  </div>

  <div class="card">
    <h3>Milestones</h3>
    @foreach($project->milestones as $milestone)
      @php($milestoneLabelKey = 'website.client.milestone_labels.'.$milestone->title)
      @php($milestoneStatusKey = 'website.client.status_labels.'.$milestone->status)
      <p><strong>{{ __($milestoneLabelKey) !== $milestoneLabelKey ? __($milestoneLabelKey) : $milestone->title }}</strong> — {{ __($milestoneStatusKey) !== $milestoneStatusKey ? __($milestoneStatusKey) : ucfirst(str_replace('_', ' ', $milestone->status)) }}</p>
    @endforeach
  </div>

  <div class="card">
    <h3>Messages</h3>
    @foreach($project->messages as $message)
      <p><strong>{{ $message->sender_type === 'admin' ? 'Team' : $message->user?->name }}</strong>: {{ $message->message }}</p>
    @endforeach
    <form action="{{ route('projects.admin.messages', $project) }}" method="POST">
      @csrf
      <div class="form-group"><textarea name="message" class="form-control" rows="4" required></textarea></div>
      <button class="btn btn-primary">Send Message</button>
    </form>
  </div>
</div>
@endsection
