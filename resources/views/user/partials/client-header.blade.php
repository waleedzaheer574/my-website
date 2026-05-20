<header class="tcw-client-topbar tcw-shared-client-header">
  <div class="tcw-client-heading">
    <button class="tcw-client-sidebar-toggle" type="button" aria-label="Open menu"><i class="fas fa-bars"></i></button>
    <div>
      <h1>{{ $clientHeaderTitle ?? 'Welcome back, '.auth()->user()->name }}</h1>
      <p>{{ $clientHeaderSubtitle ?? "Here's what's happening with your projects today." }}</p>
    </div>
  </div>
  <div class="tcw-client-top-actions">
    <label class="tcw-client-search">
      <i class="fas fa-search"></i>
      <input type="search" placeholder="Search anything...">
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
          <strong>Notifications</strong>
          <a href="{{ route('user.notifications') }}">View all</a>
        </header>
        <section>
          @forelse($headerNotifications ?? collect() as $notification)
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
      </div>
    </details>
    <details class="tcw-client-user-menu">
      <summary class="tcw-client-user-chip">
        <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        <strong>{{ auth()->user()->name }}</strong>
        <i class="fas fa-chevron-down"></i>
      </summary>
      <div>
        <a href="{{ route('user.profile.edit') }}"><i class="far fa-user"></i> Profile</a>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
      </div>
    </details>
  </div>
</header>
