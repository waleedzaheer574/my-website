@extends('layouts.website')

@section('title', $project->title)
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat{display:none!important}</style>
@endpush

@section('content')
@php($activeClientNav = 'projects')
@php($clientHeaderTitle = $project->title)
@php($clientHeaderSubtitle = __('website.client.workspace_subtitle'))
<main class="tcw-client-dashboard tcw-premium-client-dashboard">
  @include('user.partials.client-sidebar')
  <section class="tcw-client-main">
    @include('user.partials.client-header')
    <div class="tcw-project-workspace">
      <section class="tcw-client-panel">
        <div class="tcw-client-panel-head">
          <h2>{{ $project->title }}</h2>
          <span class="tcw-client-status is-{{ $project->status }}">{{ $project->status_label }}</span>
        </div>
        <div class="tcw-project-progress"><span style="width: {{ $project->progress }}%"></span></div>
        <p>{{ $project->description }}</p>
        <h3>{{ __('website.client.milestones') }}</h3>
        <div class="tcw-project-timeline">
          @foreach($project->milestones as $milestone)
            @php($milestoneLabelKey = 'website.client.milestone_labels.'.$milestone->title)
            @php($milestoneStatusKey = 'website.client.status_labels.'.$milestone->status)
            <article class="is-{{ $milestone->status }}">
              <b>{{ __($milestoneLabelKey) !== $milestoneLabelKey ? __($milestoneLabelKey) : $milestone->title }}</b>
              <span>{{ __($milestoneStatusKey) !== $milestoneStatusKey ? __($milestoneStatusKey) : ucfirst(str_replace('_', ' ', $milestone->status)) }}</span>
            </article>
          @endforeach
        </div>
      </section>

      <aside class="tcw-client-panel">
        <div class="tcw-client-panel-head"><h2>{{ __('website.client.messages') }}</h2></div>
        <div class="tcw-project-messages">
          @forelse($project->messages as $message)
            <article class="is-{{ $message->sender_type }}">
              <strong>{{ $message->sender_type === 'admin' ? __('website.client.team') : __('website.client.you') }}</strong>
              <p>{{ $message->message }}</p>
              <small>{{ $message->created_at->locale(app()->getLocale())->diffForHumans() }}</small>
            </article>
          @empty
            <p>{{ __('website.client.no_messages') }}</p>
          @endforelse
        </div>
        <form action="{{ route('user.projects.messages', $project) }}" method="POST" class="tcw-project-message-form">
          @csrf
          <textarea name="message" placeholder="{{ __('website.client.write_message') }}" required></textarea>
          <button class="tcw-saas-btn is-primary" type="submit">{{ __('website.client.send') }}</button>
        </form>
      </aside>
    </div>
  </section>
  @include('user.partials.client-mobile-nav')
</main>
@endsection

@push('js')
  @include('user.partials.client-shell-script')
@endpush
