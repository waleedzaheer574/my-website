@extends('layouts.admin')

@section('header')
  <h2 class="admin-u-001">Projects</h2>
@endsection

@section('content')
<div class="card">
  <div class="admin-u-010"><h3 class="admin-u-011">Project Tracking</h3></div>
  <div class="admin-u-012">
    <table>
      <thead><tr><th>ID</th><th>Project</th><th>Client</th><th>Status</th><th>Progress</th><th>Action</th></tr></thead>
      <tbody>
        @forelse($projects as $project)
          <tr>
            <td>{{ $project->id }}</td>
            <td><strong>{{ $project->title_label }}</strong><small>{{ $project->order?->reference }}</small></td>
            <td>{{ $project->user?->name }}</td>
            <td>{{ $project->status_label }}</td>
            <td>{{ $project->progress }}%</td>
            <td><a class="admin-u-073" href="{{ route('projects.admin.show', $project) }}">Manage</a></td>
          </tr>
        @empty
          <tr><td colspan="6" class="admin-u-015">No projects yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="admin-u-016">{{ $projects->links() }}</div>
</div>
@endsection
