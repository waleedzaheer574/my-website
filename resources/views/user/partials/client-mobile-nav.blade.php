@php($activeClientNav = $activeClientNav ?? 'dashboard')
<nav class="tcw-client-mobile-nav" aria-label="Mobile dashboard navigation">
  <a href="{{ route('user.dashboard') }}" class="{{ $activeClientNav === 'dashboard' ? 'is-active' : '' }}"><i class="fas fa-th-large"></i><span>Home</span></a>
  <a href="{{ route('user.projects') }}" class="{{ $activeClientNav === 'projects' ? 'is-active' : '' }}"><i class="fas fa-layer-group"></i><span>Projects</span></a>
  <a href="{{ route('user.orders') }}" class="{{ $activeClientNav === 'orders' ? 'is-active' : '' }}"><i class="fas fa-shopping-bag"></i><span>Orders</span></a>
  <a href="{{ route('website.offers') }}"><i class="fas fa-tags"></i><span>Offers</span></a>
  <a href="{{ route('user.notifications') }}" class="{{ $activeClientNav === 'notifications' ? 'is-active' : '' }}"><i class="far fa-bell"></i><span>Alerts</span></a>
</nav>
