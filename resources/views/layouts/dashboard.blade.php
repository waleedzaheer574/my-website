<!DOCTYPE html>
<html>
<head>
    <meta name="robots" content="noindex, nofollow, noarchive">
    <title>Dashboard</title>
</head>
<body>

    @include('partials.dashboard.topbar')
    @include('partials.dashboard.sidebar')

    <div class="dashboard-shell">
        @yield('content')
    </div>

</body>
</html>
