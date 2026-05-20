@extends('layouts.website')

@section('title', 'Projects')
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat{display:none!important}</style>
@endpush

@section('content')
@php($activeClientNav = 'projects')
@php($clientHeaderTitle = 'Projects')
@php($clientHeaderSubtitle = 'Follow active workspaces, progress, and delivery milestones.')
<main class="tcw-client-dashboard tcw-premium-client-dashboard">
  @include('user.partials.client-sidebar')
  <section class="tcw-client-main">
    @include('user.partials.client-header')
    <section class="tcw-client-panel">
      <div class="tcw-client-panel-head">
        <h2>Projects</h2>
        <a href="{{ route('website.offers') }}">Start project</a>
      </div>
      <div class="tcw-project-list">
        @forelse($projects as $project)
          <a href="{{ route('user.projects.show', $project) }}">
            <div>
              <strong>{{ $project->title }}</strong>
              <span>{{ $project->order?->reference ?: 'Project workspace' }} · {{ $project->status_label }}</span>
            </div>
            <b style="--progress: {{ $project->progress }}%"><i></i>{{ $project->progress }}%</b>
          </a>
        @empty
          <p>No projects yet.</p>
        @endforelse
      </div>
      {{ $projects->links() }}
    </section>
  </section>
  @include('user.partials.client-mobile-nav')
</main>
@endsection

@push('js')
  @include('user.partials.client-shell-script')
@endpush
