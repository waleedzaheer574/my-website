@php($activeClientNav = $activeClientNav ?? 'dashboard')
<nav class="tcw-client-mobile-nav" aria-label="{{ __('website.client.mobile_nav') }}">
  <a href="{{ route('user.dashboard') }}" class="{{ $activeClientNav === 'dashboard' ? 'is-active' : '' }}"><i class="fas fa-th-large"></i><span>{{ __('website.client.home') }}</span></a>
  <a href="{{ route('user.projects') }}" class="{{ $activeClientNav === 'projects' ? 'is-active' : '' }}"><i class="fas fa-layer-group"></i><span>{{ __('website.client.projects') }}</span></a>
  <a href="{{ route('user.orders') }}" class="{{ $activeClientNav === 'orders' ? 'is-active' : '' }}"><i class="fas fa-shopping-bag"></i><span>{{ __('website.client.orders') }}</span></a>
  <a href="{{ route('website.offers') }}"><i class="fas fa-tags"></i><span>{{ __('website.nav.offers') }}</span></a>
  <a href="{{ route('user.notifications') }}" class="{{ $activeClientNav === 'notifications' ? 'is-active' : '' }}"><i class="far fa-bell"></i><span>{{ __('website.client.notifications') }}</span></a>
</nav>
