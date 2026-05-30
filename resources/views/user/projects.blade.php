@extends('layouts.website')

@section('title', __('website.client.projects'))
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat{display:none!important}</style>
@endpush

@section('content')
@php($activeClientNav = 'projects')
@php($clientHeaderTitle = __('website.client.projects'))
@php($clientHeaderSubtitle = __('website.client.projects_subtitle'))
<main class="tcw-client-dashboard tcw-premium-client-dashboard">
  @include('user.partials.client-sidebar')
  <section class="tcw-client-main">
    @include('user.partials.client-header')
    <section class="tcw-client-panel">
      <div class="tcw-client-panel-head">
        <h2>{{ __('website.client.projects') }}</h2>
        <a href="{{ route('website.offers') }}">{{ __('website.client.start_project') }}</a>
      </div>
      <div class="tcw-project-list">
        @forelse($projects as $project)
          <a href="{{ route('user.projects.show', $project) }}">
            <div>
              <strong>{{ $project->title_label }}</strong>
              <span>{{ $project->order?->reference ?: __('website.client.project_workspace') }} · {{ $project->status_label }}</span>
            </div>
            <b style="--progress: {{ $project->progress }}%"><i></i>{{ $project->progress }}%</b>
          </a>
        @empty
          <p>{{ __('website.client.no_projects') }}</p>
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
