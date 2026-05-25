<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="robots" content="noindex, nofollow, noarchive">
    @php
        $adminBaseTitle = 'Multitechwave Admin';
        $adminNavCounts = [
            'requests' => \App\Models\ServiceRequest::count(),
            'support' => class_exists(\App\Models\SupportConversation::class) ? \App\Models\SupportConversation::count() : 0,
            'offers' => \App\Models\Offer::count(),
            'orders' => \App\Models\OfferOrder::count(),
            'subscriptions' => \App\Models\AgencySubscription::count(),
            'projects' => \App\Models\AgencyProject::count(),
            'subscribers' => \App\Models\NewsletterSubscription::count(),
        ];
        $adminHeaderNotifications = \App\Models\ServiceRequest::latest()->take(5)->get();
        $adminTitle = trim($__env->yieldContent('title'));

        if ($adminTitle === '') {
            $path = request()->path();

            $adminTitleMap = [
                'dashboard' => 'Dashboard',
                'services' => 'Services',
                'requests' => 'Service Requests',
                'dashboard/quotes' => 'Quote Requests',
                'dashboard/offers' => 'Offers',
                'dashboard/orders' => 'Orders',
                'dashboard/subscriptions' => 'Subscriptions',
                'dashboard/projects' => 'Projects',
                'blogs' => 'Blogs',
                'logos' => 'Logos',
                'reviews' => 'Client Reviews',
                'faqs' => 'FAQs',
                'portfolios' => 'Portfolios',
                'dashboard/industries' => 'Industries',
                'dashboard/case-studies' => 'Case Studies',
                'dashboard/why-nexa' => 'Why Nexa',
                'dashboard/newsletter-subscriptions' => 'Newsletter Subscribers',
                'dashboard/theme-colors' => 'Theme Colors',
                'settings' => 'Company Settings',
                'dashboard/service-details' => 'Service Details',
                'profile' => 'Profile',
                'login' => 'Login',
            ];

            $adminTitle = $adminTitleMap[$path] ?? str($path)->afterLast('/')->replace('-', ' ')->title()->value();
        }

        $adminTitle = $adminTitle !== '' ? $adminTitle . ' | ' . $adminBaseTitle : $adminBaseTitle;
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $adminTitle }}</title>
    <link rel="icon" type="image/svg+xml" sizes="any" href="{{ asset('favicon.svg') }}?v=20260513c">
    <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('favicon.png') }}?v=20260513c">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=20260513c">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v=20260513c">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('website/assets/css/plugins/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/admin-custom.css') }}">

</head>
<body class="admin-dashboard-theme @yield('body_class')">
    <div class="sidebar-overlay" id="sidebar-overlay"></div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <img class="sidebar-brand-logo" src="{{ asset('favicon.png') }}" alt="Multitechwave logo">
                <span class="sidebar-brand-copy">
                    <span class="sidebar-brand-title">Multitechwave</span>
                    <span class="sidebar-brand-subtitle">Admin Dashboard</span>
                </span>
            </a>
            <button class="sidebar-close" id="sidebar-close" type="button" aria-label="Close menu">&times;</button>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('requests.index') }}" class="menu-item {{ Request::is('requests*') ? 'active' : '' }}">
                <i class="far fa-clipboard"></i><span>Requests</span><b>{{ $adminNavCounts['requests'] }}</b>
            </a>
            <a href="{{ route('support-chats.index') }}" class="menu-item {{ Request::is('dashboard/support-chats*') ? 'active' : '' }}">
                <i class="far fa-comments"></i><span>Support Chats</span><b>{{ $adminNavCounts['support'] }}</b>
            </a>
            <a href="{{ route('quotes.index') }}" class="menu-item {{ Request::is('dashboard/quotes*') ? 'active' : '' }}">
                <i class="far fa-file-pdf"></i><span>Quote Generator</span>
            </a>
            <a href="{{ route('offers.admin.index') }}" class="menu-item {{ Request::is('dashboard/offers*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i><span>Offers</span><b>{{ $adminNavCounts['offers'] }}</b>
            </a>
            <a href="{{ route('orders.admin.index') }}" class="menu-item {{ Request::is('dashboard/orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i><span>Orders</span><b>{{ $adminNavCounts['orders'] }}</b>
            </a>
            <a href="{{ route('subscriptions.admin.index') }}" class="menu-item {{ Request::is('dashboard/subscriptions*') ? 'active' : '' }}">
                <i class="far fa-clock"></i><span>Subscriptions</span><b>{{ $adminNavCounts['subscriptions'] }}</b>
            </a>
            <a href="{{ route('projects.admin.index') }}" class="menu-item {{ Request::is('dashboard/projects*') ? 'active' : '' }}">
                <i class="fas fa-project-diagram"></i><span>Projects</span><b>{{ $adminNavCounts['projects'] }}</b>
            </a>
            <a href="{{ route('services.index') }}" class="menu-item {{ Request::is('services*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i><span>Services</span>
            </a>
            <a href="{{ route('service-details.index') }}" class="menu-item {{ Request::is('dashboard/service-details*') ? 'active' : '' }}">
                <i class="fas fa-network-wired"></i><span>Service Details</span>
            </a>
            <a href="{{ route('why-nexa.index') }}" class="menu-item {{ Request::is('dashboard/why-nexa*') ? 'active' : '' }}">
                <i class="far fa-gem"></i><span>Why Nexa</span>
            </a>
            <a href="{{ route('portfolios.index') }}" class="menu-item {{ Request::is('portfolios*') ? 'active' : '' }}">
                <i class="far fa-images"></i><span>Portfolios</span>
            </a>
            <a href="{{ route('industries.index') }}" class="menu-item {{ Request::is('dashboard/industries*') ? 'active' : '' }}">
                <i class="far fa-building"></i><span>Industries</span>
            </a>
            <a href="{{ route('case-studies.index') }}" class="menu-item {{ Request::is('dashboard/case-studies*') ? 'active' : '' }}">
                <i class="far fa-folder-open"></i><span>Case Studies</span>
            </a>
            <a href="{{ route('reviews.index') }}" class="menu-item {{ Request::is('reviews*') ? 'active' : '' }}">
                <i class="far fa-comment-dots"></i><span>Client Reviews</span>
            </a>
            <a href="{{ route('blogs.index') }}" class="menu-item {{ Request::is('blogs*') ? 'active' : '' }}">
                <i class="far fa-newspaper"></i><span>Blogs</span>
            </a>
            <a href="{{ route('faqs.index') }}" class="menu-item {{ Request::is('faqs*') ? 'active' : '' }}">
                <i class="far fa-question-circle"></i><span>FAQs</span>
            </a>
            <a href="{{ route('newsletter-subscriptions.index') }}" class="menu-item {{ Request::is('dashboard/newsletter-subscriptions*') ? 'active' : '' }}">
                <i class="fas fa-users"></i><span>Subscribers</span><b>{{ $adminNavCounts['subscribers'] }}</b>
            </a>
            <a href="{{ route('logos.index') }}" class="menu-item {{ Request::is('logos*') ? 'active' : '' }}">
                <i class="far fa-check-square"></i><span>Logos</span>
            </a>
            <a href="{{ route('settings.index') }}" class="menu-item {{ Request::is('settings*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i><span>Company Settings</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="menu-item {{ Request::is('profile*') ? 'active' : '' }}">
                <i class="far fa-user"></i><span>Profile</span>
            </a>
        </div>
        <div class="admin-sidebar-user">
            <span>{{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}</span>
            <div><strong>{{ auth()->user()?->name ?? 'Admin' }}</strong><small>Super Administrator</small></div>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div class="menu-toggle admin-menu-toggle" id="menu-toggle">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </div>
            <div class="top-bar-title">
                @yield('header')
            </div>
            <label class="admin-top-search">
                <i class="fas fa-search"></i>
                <input type="search" placeholder="Search anything...">
                <kbd>Ctrl K</kbd>
            </label>
            <div class="admin-top-actions">
                <details class="admin-notification-menu">
                    <summary class="admin-top-bell" aria-label="Notifications">
                        <i class="far fa-bell"></i>
                        <b>{{ min(9, $adminNavCounts['requests']) }}</b>
                    </summary>
                    <div>
                        <header>
                            <strong>Notifications</strong>
                            <a href="{{ route('requests.index') }}">View all</a>
                        </header>
                        @forelse($adminHeaderNotifications as $notification)
                            <a href="{{ route('requests.index') }}">
                                <i class="far fa-envelope"></i>
                                <span>
                                    <strong>{{ $notification->full_name }}</strong>
                                    <small>{{ $notification->service_type }} · {{ $notification->status_label }}</small>
                                </span>
                                <time>{{ $notification->created_at->diffForHumans() }}</time>
                            </a>
                        @empty
                            <p>No notifications yet.</p>
                        @endforelse
                    </div>
                </details>
                <div class="admin-profile-menu">
                    <button class="admin-profile-trigger" id="admin-profile-trigger" type="button" aria-haspopup="true" aria-expanded="false">
                        <span><i class="far fa-user" aria-hidden="true"></i></span>
                        <strong>{{ auth()->user()?->name ?? 'Admin' }}</strong>
                        <i class="fas fa-chevron-down admin-profile-chevron" aria-hidden="true"></i>
                    </button>
                    <div class="admin-profile-dropdown" id="admin-profile-dropdown">
                        <a href="{{ route('profile.edit') }}">Profile</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="{{ asset('website/assets/js/admin-custom.js') }}"></script>
</body>
</html>
