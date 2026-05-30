<header class="tcw-client-topbar tcw-shared-client-header">
  <div class="tcw-client-heading">
    <button class="tcw-client-sidebar-toggle" type="button" aria-label="{{ __('website.client.open_menu') }}"><i class="fas fa-bars"></i></button>
    <div>
      <h1>{{ $clientHeaderTitle ?? __('website.client.welcome', ['name' => auth()->user()->name]) }}</h1>
      <p>{{ $clientHeaderSubtitle ?? __('website.client.today') }}</p>
    </div>
  </div>
  <div class="tcw-client-top-actions">
    <label class="tcw-client-search">
      <i class="fas fa-search"></i>
      <input type="search" placeholder="{{ __('website.client.search') }}">
      <kbd>Ctrl K</kbd>
    </label>
    <details class="tcw-client-language-menu">
      <summary aria-label="{{ __('website.language.label') }}">
        <span class="tcw-client-language-orb"><i class="fas fa-globe"></i></span>
        <span class="tcw-client-language-current">
          <small>{{ __('website.language.label') }}</small>
          <strong>{{ app()->getLocale() === 'ar' ? __('website.language.arabic') : __('website.language.english') }}</strong>
        </span>
        <i class="fas fa-chevron-down tcw-client-language-caret"></i>
      </summary>
      <div class="tcw-client-language-panel">
        <header>
          <i class="fas fa-language"></i>
          <span>{{ __('website.language.label') }}</span>
        </header>
        <a href="{{ route('language.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'is-active' : '' }}" lang="en">
          <b>EN</b>
          <span>{{ __('website.language.english') }}</span>
          <i class="fas fa-check"></i>
        </a>
        <a href="{{ route('language.switch', 'ar') }}" class="{{ app()->getLocale() === 'ar' ? 'is-active' : '' }}" lang="ar">
          <b>AR</b>
          <span dir="rtl">{{ __('website.language.arabic') }}</span>
          <i class="fas fa-check"></i>
        </a>
      </div>
    </details>
    <details class="tcw-client-notification-menu">
      <summary class="tcw-client-bell {{ $unreadNotificationsCount ? 'has-unread' : '' }}">
        <i class="far fa-bell"></i>
        @if($unreadNotificationsCount)
          <b>{{ $unreadNotificationsCount }}</b>
        @endif
      </summary>
      <div>
        <header>
          <strong>{{ __('website.client.notifications') }}</strong>
          <a href="{{ route('user.notifications') }}">{{ __('website.client.view_all') }}</a>
        </header>
        <section>
          @forelse($headerNotifications ?? collect() as $notification)
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
      </div>
    </details>
    <details class="tcw-client-user-menu">
      <summary class="tcw-client-user-chip">
        <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        <strong>{{ auth()->user()->name }}</strong>
        <i class="fas fa-chevron-down"></i>
      </summary>
      <div>
        <a href="{{ route('user.profile.edit') }}"><i class="far fa-user"></i> {{ __('website.client.profile') }}</a>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit"><i class="fas fa-sign-out-alt"></i> {{ __('website.client.logout') }}</button>
        </form>
      </div>
    </details>
  </div>
</header>
