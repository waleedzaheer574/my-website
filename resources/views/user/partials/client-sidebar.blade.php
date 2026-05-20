@php
  $serviceRequestsCount = $serviceRequestsCount ?? ($serviceRequests ?? collect())->count();
  $quoteRequestsCount = $quoteRequestsCount ?? ($quoteRequests ?? collect())->count();
  $projectsCount = $projectsCount ?? ($projects ?? collect())->count();
  $ordersCount = $ordersCount ?? ($orders ?? collect())->count();
  $subscriptionsCount = $subscriptionsCount ?? ($subscriptions ?? collect())->count();
  $unreadNotificationsCount = $unreadNotificationsCount ?? 0;
  $activeClientNav = $activeClientNav ?? 'dashboard';
@endphp

<div class="tcw-client-sidebar-overlay"></div>
<aside class="tcw-client-sidebar tcw-premium-client-sidebar">
  <div class="tcw-client-brand-row">
    <a href="{{ route('website.home') }}" class="tcw-client-brand">
      <img src="{{ asset('favicon.png') }}" alt="Multitechwave logo">
      <strong>Multitechwave<small>Technology. Innovation. Solutions.</small></strong>
    </a>
    <button class="tcw-client-sidebar-close" type="button" aria-label="Close menu">&times;</button>
  </div>

  <nav aria-label="Client dashboard">
    <a href="{{ route('user.dashboard') }}" class="{{ $activeClientNav === 'dashboard' ? 'is-active' : '' }}"><i class="fas fa-th-large"></i> Dashboard</a>
    <span>Requests</span>
    <a href="{{ route('user.service-requests') }}" class="{{ $activeClientNav === 'service-requests' ? 'is-active' : '' }}"><i class="far fa-file-alt"></i> Service Requests <b>{{ $serviceRequestsCount }}</b></a>
    <a href="{{ route('user.quote-requests') }}" class="{{ $activeClientNav === 'quote-requests' ? 'is-active' : '' }}"><i class="far fa-file-pdf"></i> Quote Requests <b>{{ $quoteRequestsCount }}</b></a>
    <a href="{{ route('user.projects') }}" class="{{ $activeClientNav === 'projects' ? 'is-active' : '' }}"><i class="fas fa-layer-group"></i> Projects <b>{{ $projectsCount }}</b></a>
    <a href="{{ route('user.orders') }}" class="{{ $activeClientNav === 'orders' ? 'is-active' : '' }}"><i class="fas fa-shopping-bag"></i> Orders <b>{{ $ordersCount }}</b></a>
    <a href="{{ route('user.subscriptions') }}" class="{{ $activeClientNav === 'subscriptions' ? 'is-active' : '' }}"><i class="fas fa-sync-alt"></i> Subscriptions <b>{{ $subscriptionsCount }}</b></a>
    <a href="#"><i class="far fa-file-alt"></i> Invoices</a>
    <a href="#"><i class="far fa-credit-card"></i> Payments</a>
    <a href="{{ route('user.support-chat') }}" class="{{ $activeClientNav === 'support' ? 'is-active' : '' }}"><i class="far fa-comments"></i> Pappert Chat <b>2</b></a>
    <a href="{{ route('user.notifications') }}" class="{{ $activeClientNav === 'notifications' ? 'is-active' : '' }}"><i class="far fa-bell"></i> Notifications <b>{{ $unreadNotificationsCount }}</b></a>
    <a href="{{ route('user.profile.edit') }}" class="{{ $activeClientNav === 'settings' ? 'is-active' : '' }}"><i class="fas fa-cog"></i> Settings</a>
  </nav>

  <div class="tcw-client-help-card">
    <h3>Need Help?</h3>
    <p>Our support team is ready to assist you 24/7</p>
    <a href="{{ route('user.support-chat') }}">Contact Support</a>
  </div>

  <div class="tcw-client-profile-mini">
    <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
    <div>
      <strong>{{ auth()->user()->name }}</strong>
      <small>{{ auth()->user()->email }}</small>
    </div>
  </div>
</aside>

<a href="{{ route('website.home') }}" class="tcw-back-website-float" aria-label="Back to website">
  <i class="fas fa-globe"></i>
  <span>Website</span>
</a>

@include('user.partials.client-success-popup')
