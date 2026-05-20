@extends('layouts.website')

@section('title', $project->title)
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat{display:none!important}</style>
@endpush

@section('content')
@php($activeClientNav = 'projects')
@php($clientHeaderTitle = $project->title)
@php($clientHeaderSubtitle = 'Project workspace, milestones, progress, and team messages.')
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
        <h3>Milestones</h3>
        <div class="tcw-project-timeline">
          @foreach($project->milestones as $milestone)
            <article class="is-{{ $milestone->status }}">
              <b>{{ $milestone->title }}</b>
              <span>{{ ucfirst(str_replace('_', ' ', $milestone->status)) }}</span>
            </article>
          @endforeach
        </div>
      </section>

      <aside class="tcw-client-panel">
        <div class="tcw-client-panel-head"><h2>Messages</h2></div>
        <div class="tcw-project-messages">
          @forelse($project->messages as $message)
            <article class="is-{{ $message->sender_type }}">
              <strong>{{ $message->sender_type === 'admin' ? 'Team' : 'You' }}</strong>
              <p>{{ $message->message }}</p>
              <small>{{ $message->created_at->diffForHumans() }}</small>
            </article>
          @empty
            <p>No messages yet.</p>
          @endforelse
        </div>
        <form action="{{ route('user.projects.messages', $project) }}" method="POST" class="tcw-project-message-form">
          @csrf
          <textarea name="message" placeholder="Write a message..." required></textarea>
          <button class="tcw-saas-btn is-primary" type="submit">Send</button>
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
