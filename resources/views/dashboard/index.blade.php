@extends('layouts.admin')

@section('body_class', 'admin-dashboard-theme admin-premium-dashboard')

@section('header')
    <h2 class="admin-u-001">Dashboard Overview</h2>
@endsection

@section('content')
    @php
        $summaryCards = [
            ['label' => 'Services', 'value' => $stats['services'], 'icon' => 'layers', 'icon_class' => 'fas fa-layer-group', 'note' => 'Core service entries', 'trend' => '12%', 'tone' => 'blue', 'spark' => '4,50 18,43 30,47 43,34 57,38 72,24 88,28 104,14 116,18'],
            ['label' => 'Offers', 'value' => $stats['offers'], 'icon' => 'detail', 'icon_class' => 'fas fa-tags', 'note' => 'Sellable packages', 'trend' => '8%', 'tone' => 'purple', 'spark' => '4,45 18,35 31,40 45,26 59,42 74,24 88,17 103,5 116,14'],
            ['label' => 'Orders', 'value' => $stats['orders'], 'icon' => 'blog', 'icon_class' => 'fas fa-shopping-cart', 'note' => 'Client purchases', 'trend' => '4%', 'tone' => 'green', 'spark' => '4,42 17,36 31,46 45,28 58,30 72,18 87,22 101,10 116,21'],
            ['label' => 'Service Requests', 'value' => $stats['service_requests'], 'icon' => 'request', 'icon_class' => 'far fa-envelope', 'note' => 'Incoming website leads', 'trend' => '15%', 'tone' => 'orange', 'spark' => '4,48 17,38 30,43 44,31 58,36 72,18 86,27 101,10 116,15'],
            ['label' => 'Projects', 'value' => $stats['projects'], 'icon' => 'layers', 'icon_class' => 'fas fa-chart-line', 'note' => 'Active workspaces', 'trend' => '20%', 'tone' => 'cyan', 'spark' => '4,46 18,36 32,39 46,45 60,28 74,31 88,16 102,9 116,18'],
            ['label' => 'Revenue', 'value' => 'AED '.number_format($stats['paid_orders_total']), 'icon' => 'detail', 'icon_class' => 'fas fa-dollar-sign', 'note' => 'Paid order value', 'trend' => '18%', 'tone' => 'pink', 'spark' => '4,47 18,39 32,42 46,31 60,44 75,26 89,21 103,9 116,17'],
        ];
        $contentTotalItems = collect($contentMix)->sum('count');
    @endphp

    <section class="admin-premium-grid">
        @foreach($summaryCards as $card)
            <article class="admin-premium-stat is-{{ $card['tone'] }}">
                <i class="{{ $card['icon_class'] }}" aria-hidden="true"></i>
                <span>{{ $card['label'] }}</span>
                <strong>{{ $card['value'] }}</strong>
                <small>{{ $card['note'] }}</small>
                <em><i class="fas fa-arrow-up"></i> {{ $card['trend'] }} this month</em>
                <svg class="admin-stat-spark" viewBox="0 0 120 56" aria-hidden="true" preserveAspectRatio="none">
                    <polyline points="{{ $card['spark'] }}"></polyline>
                </svg>
                <b></b>
            </article>
        @endforeach

        <article class="admin-premium-card admin-premium-support">
            <header><h2>Support Overview</h2><span>This Month <i class="fas fa-chevron-down"></i></span></header>
            <div>
                <span><strong>{{ $supportOverview['active'] }}</strong><small>Active Chats</small></span>
                <span><strong>{{ $supportOverview['open'] }}</strong><small>Open Tickets</small></span>
                <span><strong>{{ $supportOverview['resolved'] }}</strong><small>Resolved</small></span>
            </div>
            <svg class="admin-support-spark" viewBox="0 0 420 90" aria-hidden="true" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="adminSupportSparkFill" x1="0" x2="0" y1="0" y2="1">
                        <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.28" />
                        <stop offset="100%" stop-color="#38bdf8" stop-opacity="0" />
                    </linearGradient>
                </defs>
                <path d="M0 76 L42 66 L84 70 L126 52 L168 56 L210 34 L252 44 L294 26 L336 30 L378 18 L420 24 L420 90 L0 90 Z"></path>
                <polyline points="0,76 42,66 84,70 126,52 168,56 210,34 252,44 294,26 336,30 378,18 420,24"></polyline>
            </svg>
        </article>

        <article class="admin-premium-card admin-premium-activity">
            <header><h2>6-Month Activity</h2><span>This Year <i class="fas fa-chevron-down"></i></span></header>
            <div class="admin-premium-bars">
                @foreach($monthlyActivity as $month)
                    <div>
                        <b>
                            <i style="height: {{ ($month['services'] / $maxActivity) * 100 }}%"></i>
                            <i style="height: {{ ($month['blogs'] / $maxActivity) * 100 }}%"></i>
                            <i style="height: {{ ($month['requests'] / $maxActivity) * 100 }}%"></i>
                            <i style="height: {{ ($month['orders'] / $maxActivity) * 100 }}%"></i>
                        </b>
                        <span>{{ $month['label'] }}</span>
                    </div>
                @endforeach
            </div>
            <footer><span>Services</span><span>Blogs</span><span>Requests</span><span>Orders</span></footer>
        </article>

        <article class="admin-premium-card admin-premium-mix">
            <header><h2>Content Mix</h2></header>
            <div>
                <figure style="--services: {{ $contentMix[0]['width'] }}%; --details: {{ $contentMix[1]['width'] }}%; --blogs: {{ $contentMix[2]['width'] }}%; --requests: {{ $contentMix[3]['width'] }}%;">
                    <strong>{{ $contentTotalItems }}</strong>
                    <span>Total Items</span>
                </figure>
                <ul>
                    @foreach($contentMix as $item)
                        <li style="--item-color: {{ $item['color'] }}"><span>{{ $item['label'] }}</span><b>{{ $item['count'] }}</b><small>{{ $item['width'] }}%</small></li>
                    @endforeach
                </ul>
            </div>
        </article>

        <article class="admin-premium-card admin-premium-list admin-card-recent-services">
            <header><h2>Recent Services</h2><a href="{{ route('services.index') }}">View all</a></header>
            @forelse($recentServices as $service)
                <div>
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p><strong>{{ $service->service_title }}</strong><span>{{ \Illuminate\Support\Str::limit($service->service_description, 72) }}</span></p>
                    <time>{{ $service->created_at->format('d M, Y') }}</time>
                </div>
            @empty
                <p>No services added yet.</p>
            @endforelse
        </article>

        <article class="admin-premium-card admin-premium-list admin-card-service-requests">
            <header><h2>Service Requests</h2><a href="{{ route('requests.index') }}">View all</a></header>
            @forelse($recentRequests as $request)
                <div>
                    <p>
                        <strong>{{ $request->full_name }}{{ $request->company_name ? ' · '.$request->company_name : '' }}</strong>
                        <span>{{ $request->service_type }}</span>
                        <mark>{{ $request->status_label }}</mark>
                    </p>
                    <time>{{ $request->created_at->format('d M, Y h:i A') }}</time>
                </div>
            @empty
                <p>No service requests yet.</p>
            @endforelse
        </article>

        <article class="admin-premium-card admin-premium-list is-wide admin-card-recent-blogs">
            <header><h2>Recent Blogs</h2><a href="{{ route('blogs.index') }}">View all</a></header>
            @forelse($recentBlogs as $blog)
                <div>
                    <img src="{{ asset($blog->featured_image) }}" alt="">
                    <p><strong>{{ $blog->title }}</strong><span>{{ $blog->author_name }} · {{ $blog->category ?: 'Blog' }}</span></p>
                    <time>{{ $blog->created_at->format('d M, Y') }}</time>
                </div>
            @empty
                <p>No blogs added yet.</p>
            @endforelse
        </article>

        <article class="admin-premium-card admin-premium-list admin-card-recent-orders">
            <header><h2>Recent Orders</h2><a href="{{ route('orders.admin.index') }}">View all</a></header>
            @forelse($recentOrders as $order)
                <div>
                    <p><strong>{{ $order->reference }}</strong><span>{{ $order->offer?->title ?? 'Custom Offer' }} · {{ $order->user?->name ?? $order->client_name }}</span><mark class="{{ $order->payment_status === 'paid' ? 'is-paid' : '' }}">{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</mark></p>
                    <time>{{ $order->amount_label }}<br>{{ $order->created_at->format('d M, Y h:i A') }}</time>
                </div>
            @empty
                <p>No orders yet.</p>
            @endforelse
        </article>

        <article class="admin-premium-card admin-premium-projects admin-card-recent-projects">
            <header><h2>Recent Projects</h2><a href="{{ route('projects.admin.index') }}">View all</a></header>
            @forelse($recentProjects as $project)
                <div>
                    <p><strong>{{ $project->title }}</strong><span>{{ $project->user?->name ?? 'Client' }} · {{ $project->order?->reference ?? 'Project' }}</span></p>
                    <mark>{{ $project->status_label }}</mark>
                    <b><i style="width: {{ $project->progress }}%"></i></b>
                    <time>{{ $project->progress }}% · {{ $project->created_at->format('d M, Y h:i A') }}</time>
                </div>
            @empty
                <p>No projects yet.</p>
            @endforelse
        </article>

        <article class="admin-premium-card admin-premium-top admin-card-top-services">
            <header><h2>Top Services</h2><span>This Month <i class="fas fa-chevron-down"></i></span></header>
            @forelse($topServices as $service)
                <div>
                    <i class="fas fa-globe"></i>
                    <p><strong>{{ $service->service_type }}</strong><span>{{ $service->aggregate }} Requests</span></p>
                    <b>{{ round(($service->aggregate / $topServicesTotal) * 100) }}%</b>
                </div>
            @empty
                <p>No service data yet.</p>
            @endforelse
        </article>

        <article class="admin-premium-card admin-premium-actions admin-card-quick-actions">
            <header><h2>Quick Actions</h2></header>
            <div>
                <a href="{{ route('services.create') }}"><i class="fas fa-plus-circle"></i><span>Add Service</span></a>
                <a href="{{ route('offers.admin.create') }}"><i class="fas fa-tags"></i><span>Create Offer</span></a>
                <a href="{{ route('orders.admin.index') }}"><i class="fas fa-shopping-cart"></i><span>New Order</span></a>
                <a href="{{ route('blogs.create') }}"><i class="far fa-newspaper"></i><span>New Blog</span></a>
                <a href="{{ route('orders.admin.index') }}"><i class="far fa-file-alt"></i><span>View Invoices</span></a>
                <a href="{{ route('settings.index') }}"><i class="fas fa-cog"></i><span>Settings</span></a>
            </div>
        </article>

    </section>
@endsection
