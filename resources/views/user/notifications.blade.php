@extends('layouts.website')

@section('title', 'Notifications')
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat { display:none !important; }</style>
@endpush

@section('content')
  @php($activeClientNav = 'notifications')
  @php($clientHeaderTitle = 'Notifications')
  @php($clientHeaderSubtitle = 'All request and project updates in one place.')
  <main class="tcw-client-dashboard tcw-premium-client-dashboard tcw-notification-page">
    @include('user.partials.client-sidebar')
    <section class="tcw-client-main">
      @include('user.partials.client-header')
      <header class="tcw-notification-header">
        <div class="tcw-page-heading">
          <div><h1>Notifications</h1><p>All request and project updates in one place.</p></div>
        </div>
      </header>
      <section class="tcw-notification-list">
        @forelse($notifications as $notification)
          <a href="{{ route('user.notifications.open', $notification->id) }}" class="{{ $notification->read_at ? '' : 'is-unread' }}">
            <i class="{{ $notification->data['icon'] ?? 'far fa-bell' }}"></i>
            <div>
              <strong>{{ $notification->data['title'] ?? 'Update' }}</strong>
              <span>{{ $notification->data['message'] ?? 'Your request was updated.' }}</span>
              <time>{{ $notification->created_at->diffForHumans() }}</time>
            </div>
          </a>
        @empty
          <p>No notifications yet.</p>
        @endforelse
      </section>
      <div class="tcw-user-pagination">{{ $notifications->links() }}</div>
    </section>
    @include('user.partials.client-mobile-nav')
  </main>
@endsection

@push('js')
  @include('user.partials.client-shell-script')
@endpush
