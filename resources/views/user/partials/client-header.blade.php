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
            <a href="{{ route('user.notifications.open', $notification->id) }}" class="{{ $notification->read_at ? '' : 'is-unread' }}">
              <i class="{{ $notification->data['icon'] ?? 'far fa-bell' }}"></i>
              <div>
                <strong>{{ $notification->data['title'] ?? __('website.client.update') }}</strong>
                <span>{{ $notification->data['message'] ?? __('website.client.request_updated') }}</span>
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
