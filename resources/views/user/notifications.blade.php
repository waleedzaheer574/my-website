@extends('layouts.website')

@section('title', __('website.client.notifications'))
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat { display:none !important; }</style>
@endpush

@section('content')
  @php($activeClientNav = 'notifications')
  @php($clientHeaderTitle = __('website.client.notifications'))
  @php($clientHeaderSubtitle = __('website.client.notifications_subtitle'))
  <main class="tcw-client-dashboard tcw-premium-client-dashboard tcw-notification-page">
    @include('user.partials.client-sidebar')
    <section class="tcw-client-main">
      @include('user.partials.client-header')
      <header class="tcw-notification-header">
        <div class="tcw-page-heading">
          <div><h1>{{ __('website.client.notifications') }}</h1><p>{{ __('website.client.notifications_subtitle') }}</p></div>
        </div>
      </header>
      <section class="tcw-notification-list">
        @forelse($notifications as $notification)
          @php
            $notificationEvent = $notification->data['event'] ?? null;
            $notificationTitleKey = $notificationEvent ? 'website.client.notification_events.'.$notificationEvent.'.title' : null;
            $notificationMessageKey = $notificationEvent ? 'website.client.notification_events.'.$notificationEvent.'.message' : null;
            $notificationTitle = $notificationTitleKey && __($notificationTitleKey) !== $notificationTitleKey ? __($notificationTitleKey) : ($notification->data['title'] ?? __('website.client.update'));
            $notificationMessage = $notificationMessageKey && __($notificationMessageKey) !== $notificationMessageKey ? __($notificationMessageKey) : ($notification->data['message'] ?? __('website.client.request_updated'));
          @endphp
          <a href="{{ route('user.notifications.open', $notification->id) }}" class="{{ $notification->read_at ? '' : 'is-unread' }}">
            <i class="{{ $notification->data['icon'] ?? 'far fa-bell' }}"></i>
            <div>
              <strong>{{ $notificationTitle }}</strong>
              <span>{{ $notificationMessage }}</span>
              <time>{{ $notification->created_at->locale(app()->getLocale())->diffForHumans() }}</time>
            </div>
          </a>
        @empty
          <p>{{ __('website.client.no_notifications') }}</p>
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
