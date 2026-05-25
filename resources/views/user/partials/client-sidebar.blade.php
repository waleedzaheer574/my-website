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
      <strong>Multitechwave<small>{{ __('website.client.brand_line') }}</small></strong>
    </a>
    <button class="tcw-client-sidebar-close" type="button" aria-label="{{ __('website.client.close_menu') }}">&times;</button>
  </div>

  <nav aria-label="{{ __('website.client.dashboard_nav') }}">
    <a href="{{ route('user.dashboard') }}" class="{{ $activeClientNav === 'dashboard' ? 'is-active' : '' }}"><i class="fas fa-th-large"></i> {{ __('website.client.dashboard') }}</a>
    <span>{{ __('website.client.requests') }}</span>
    <a href="{{ route('user.service-requests') }}" class="{{ $activeClientNav === 'service-requests' ? 'is-active' : '' }}"><i class="far fa-file-alt"></i> {{ __('website.client.service_requests') }} <b>{{ $serviceRequestsCount }}</b></a>
    <a href="{{ route('user.quote-requests') }}" class="{{ $activeClientNav === 'quote-requests' ? 'is-active' : '' }}"><i class="far fa-file-pdf"></i> {{ __('website.client.quote_requests') }} <b>{{ $quoteRequestsCount }}</b></a>
    <a href="{{ route('user.projects') }}" class="{{ $activeClientNav === 'projects' ? 'is-active' : '' }}"><i class="fas fa-layer-group"></i> {{ __('website.client.projects') }} <b>{{ $projectsCount }}</b></a>
    <a href="{{ route('user.orders') }}" class="{{ $activeClientNav === 'orders' ? 'is-active' : '' }}"><i class="fas fa-shopping-bag"></i> {{ __('website.client.orders') }} <b>{{ $ordersCount }}</b></a>
    <a href="{{ route('user.subscriptions') }}" class="{{ $activeClientNav === 'subscriptions' ? 'is-active' : '' }}"><i class="fas fa-sync-alt"></i> {{ __('website.client.subscriptions') }} <b>{{ $subscriptionsCount }}</b></a>
    <a href="#"><i class="far fa-file-alt"></i> {{ __('website.client.invoices') }}</a>
    <a href="#"><i class="far fa-credit-card"></i> {{ __('website.client.payments') }}</a>
    <a href="{{ route('user.support-chat') }}" class="{{ $activeClientNav === 'support' ? 'is-active' : '' }}"><i class="far fa-comments"></i> {{ __('website.client.chat') }} <b>2</b></a>
    <a href="{{ route('user.notifications') }}" class="{{ $activeClientNav === 'notifications' ? 'is-active' : '' }}"><i class="far fa-bell"></i> {{ __('website.client.notifications') }} <b>{{ $unreadNotificationsCount }}</b></a>
    <a href="{{ route('user.profile.edit') }}" class="{{ $activeClientNav === 'settings' ? 'is-active' : '' }}"><i class="fas fa-cog"></i> {{ __('website.client.settings') }}</a>
  </nav>

  <div class="tcw-client-help-card">
    <h3>{{ __('website.client.need_help') }}</h3>
    <p>{{ __('website.client.help_text') }}</p>
    <a href="{{ route('user.support-chat') }}">{{ __('website.client.contact_support') }}</a>
  </div>

  <div class="tcw-client-profile-mini">
    <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
    <div>
      <strong>{{ auth()->user()->name }}</strong>
      <small>{{ auth()->user()->email }}</small>
    </div>
  </div>
</aside>

<a href="{{ route('website.home') }}" class="tcw-back-website-float" aria-label="{{ __('website.client.back_website') }}">
  <i class="fas fa-globe"></i>
  <span>{{ __('website.client.website') }}</span>
</a>

@include('user.partials.client-success-popup')
