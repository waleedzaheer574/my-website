@extends('layouts.website')

@section('title', __('website.client.dashboard'))
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat{display:none!important}</style>
@endpush

@section('content')
@php
  $activeClientNav = 'dashboard';
  $requestOverview = $requestOverview ?? ['total' => $serviceRequests->count() + $quoteRequests->count(), 'segments' => collect(), 'gradient' => 'conic-gradient(rgba(37, 99, 235, 0.22) 0 100%)'];
  $requestOverviewSegments = collect($requestOverview['segments'] ?? []);
  $totalRequests = (int) ($requestOverview['total'] ?? ($serviceRequests->count() + $quoteRequests->count()));
  $completedProjects = $projects->where('status', 'completed')->count();
  $inProgressProjects = $projects->where('status', 'in_progress')->count();
  $totalSpent = $orders->sum('amount');
  $pendingPayments = $orders->where('payment_status', 'pending')->count();
  $recentRows = $serviceRequests->take(3)->map(fn ($request) => [
      'id' => 'SR-'.str_pad((string) $request->id, 4, '0', STR_PAD_LEFT),
      'title' => $request->company_name ?: $request->service_label,
      'service' => $request->service_label,
      'status' => $request->status,
      'status_label' => $request->status_label,
      'date' => $request->created_at,
  ]);
@endphp

<main class="tcw-client-dashboard tcw-premium-client-dashboard">
  @include('user.partials.client-sidebar')

  <section class="tcw-client-main" id="overview">
    @include('user.partials.client-header')

    <div class="tcw-dashboard-overview-row">
      <div class="tcw-premium-stat-grid">
        <article class="is-purple"><i class="far fa-file-alt"></i><div><span>{{ __('website.client.total_requests') }}</span><strong>{{ str_pad((string) $totalRequests, 2, '0', STR_PAD_LEFT) }}</strong><small>{{ __('website.client.from_last_month', ['percent' => '+20%']) }}</small></div><svg class="tcw-client-stat-spark" viewBox="0 0 120 56" preserveAspectRatio="none" aria-hidden="true"><polyline points="4,50 18,43 30,47 43,34 57,38 72,24 88,28 104,14 116,18"></polyline></svg></article>
        <article class="is-blue"><i class="fas fa-wave-square"></i><div><span>{{ __('website.client.in_progress') }}</span><strong>{{ str_pad((string) $inProgressProjects, 2, '0', STR_PAD_LEFT) }}</strong><small>{{ __('website.client.active_projects') }}</small></div><svg class="tcw-client-stat-spark" viewBox="0 0 120 56" preserveAspectRatio="none" aria-hidden="true"><polyline points="4,46 18,42 32,39 46,35 60,30 74,32 88,26 102,20 116,16"></polyline></svg></article>
        <article class="is-green"><i class="far fa-check-circle"></i><div><span>{{ __('website.client.completed') }}</span><strong>{{ str_pad((string) $completedProjects, 2, '0', STR_PAD_LEFT) }}</strong><small>{{ __('website.client.from_last_month', ['percent' => '+25%']) }}</small></div><svg class="tcw-client-stat-spark" viewBox="0 0 120 56" preserveAspectRatio="none" aria-hidden="true"><polyline points="4,42 17,36 31,46 45,28 58,30 72,18 87,22 101,10 116,21"></polyline></svg></article>
        <article class="is-orange"><i class="fas fa-dollar-sign"></i><div><span>{{ __('website.client.total_spent') }}</span><strong>AED {{ number_format($totalSpent) }}</strong><small>{{ __('website.client.from_last_month', ['percent' => '+18%']) }}</small></div><svg class="tcw-client-stat-spark" viewBox="0 0 120 56" preserveAspectRatio="none" aria-hidden="true"><polyline points="4,47 18,39 32,42 46,31 60,44 75,26 89,21 103,9 116,17"></polyline></svg></article>
        <article class="is-red"><i class="far fa-credit-card"></i><div><span>{{ __('website.client.pending_payments') }}</span><strong>{{ str_pad((string) $pendingPayments, 2, '0', STR_PAD_LEFT) }}</strong><small>{{ __('website.client.awaiting_payment') }}</small></div><svg class="tcw-client-stat-spark" viewBox="0 0 120 56" preserveAspectRatio="none" aria-hidden="true"><polyline points="4,45 18,38 31,40 45,29 59,42 74,25 88,18 103,13 116,18"></polyline></svg></article>
      </div>

      <section class="tcw-client-panel tcw-updates-card">
        <div class="tcw-client-panel-head"><h2>{{ __('website.client.recent_updates') }}</h2><a href="{{ route('user.notifications') }}">{{ __('website.client.view_all') }}</a></div>
        @forelse(($recentRequests ?? collect())->take(4) as $recentRequest)
          <article><i class="{{ $recentRequest['type'] === 'quote' ? 'far fa-envelope' : 'far fa-comment-dots' }}"></i><p>{{ __('website.client.status_changed', ['title' => $recentRequest['title'], 'status' => $recentRequest['subtitle']]) }}</p><time>{{ $recentRequest['date']->locale(app()->getLocale())->diffForHumans() }}</time></article>
        @empty
          <article><i class="far fa-comment-dots"></i><p>{{ __('website.client.no_updates') }}</p><time>{{ __('website.client.now') }}</time></article>
        @endforelse
      </section>
    </div>

    <div class="tcw-dashboard-grid">
      <section class="tcw-client-panel tcw-chart-card tcw-donut-card">
        <div class="tcw-client-panel-head"><h2>{{ __('website.client.requests_overview') }}</h2></div>
        <div class="tcw-donut-wrap">
          <div class="tcw-css-donut" style="--tcw-donut-gradient: {{ $requestOverview['gradient'] }}"><strong>{{ $totalRequests ?: 0 }}</strong><span>{{ __('website.client.total') }}</span></div>
          <div class="tcw-donut-legend">
            @foreach($requestOverviewSegments as $segment)
              <p>
                <i style="background: {{ $segment['color'] }}"></i>
                {{ $segment['label'] }}
                <b>{{ str_pad((string) $segment['count'], 2, '0', STR_PAD_LEFT) }}</b>
                <em>{{ number_format($segment['percent'], $segment['percent'] == (int) $segment['percent'] ? 0 : 1) }}%</em>
              </p>
            @endforeach
            <a href="{{ route('user.service-requests') }}">{{ __('website.client.full_reports') }} <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </section>

      <section class="tcw-client-panel tcw-chart-card">
        <div class="tcw-client-panel-head">
          <h2>{{ __('website.client.activity_overview') }}</h2>
          <label class="tcw-activity-month-select">
            <select id="activityMonthSelect" aria-label="{{ __('website.client.select_month') }}">
              @foreach($activityMonths as $month)
                <option value="{{ $month['key'] }}">{{ $loop->first ? __('website.client.this_month') : $month['shortLabel'] }}</option>
              @endforeach
            </select>
            <i class="fas fa-chevron-down"></i>
          </label>
        </div>
        <div class="tcw-line-chart" id="activityChart" data-activity='@json($activityMonths)'>
          <svg viewBox="0 0 360 180" role="img" aria-label="{{ __('website.client.monthly_activity') }}" preserveAspectRatio="none">
            <defs>
              <linearGradient id="tcwActivityFill" x1="0" x2="0" y1="0" y2="1">
                <stop offset="0%" stop-color="#8b5cf6" stop-opacity="0.45" />
                <stop offset="100%" stop-color="#8b5cf6" stop-opacity="0" />
              </linearGradient>
            </defs>
            <path class="tcw-activity-area" d=""></path>
            <polyline class="tcw-activity-line" points=""></polyline>
            <g class="tcw-activity-dots"></g>
          </svg>
          <b id="activityTooltip">0 {{ __('website.client.activities') }}</b>
          <div class="tcw-activity-axis">
            <span>{{ __('website.client.day_one') }}</span>
            <span id="activityMonthLabel">{{ __('website.client.this_month') }}</span>
            <span>{{ __('website.client.end') }}</span>
          </div>
        </div>
      </section>

      <section class="tcw-client-panel tcw-recent-requests-card">
        <div class="tcw-client-panel-head"><h2>{{ __('website.client.recent_requests') }}</h2><a href="{{ route('user.service-requests') }}">{{ __('website.client.view_all') }}</a></div>
        <div class="tcw-client-table-wrap">
          <table>
            <thead><tr><th>{{ __('website.client.request_id') }}</th><th>{{ __('website.client.service') }}</th><th>{{ __('website.client.status') }}</th><th>{{ __('website.client.date') }}</th><th>{{ __('website.client.action') }}</th></tr></thead>
            <tbody>
              @forelse($recentRows as $row)
                <tr>
                  <td><strong>{{ $row['id'] }}</strong><small>{{ $row['title'] }}</small></td>
                  <td><i class="fas fa-globe"></i> {{ $row['service'] }}</td>
                  <td><span class="tcw-client-status is-{{ $row['status'] }}">{{ $row['status_label'] }}</span></td>
                  <td>{{ $row['date']->locale(app()->getLocale())->translatedFormat('M d, Y') }}<small>{{ $row['date']->format('h:i A') }}</small></td>
                  <td><a href="{{ route('user.service-requests') }}">{{ __('website.client.view') }}</a></td>
                </tr>
              @empty
                <tr><td colspan="5" class="tcw-client-empty">{{ __('website.client.no_recent_requests') }}</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="tcw-client-mobile-list">
          @forelse($recentRows as $row)
            <article><i class="far fa-file-alt"></i><div><strong>{{ $row['id'] }}</strong><span>{{ $row['service'] }}</span><b class="tcw-client-status is-{{ $row['status'] }}">{{ $row['status_label'] }}</b></div></article>
          @empty
            <p>{{ __('website.client.no_recent_requests') }}</p>
          @endforelse
        </div>
      </section>

      <section class="tcw-client-panel tcw-deadlines-card">
        <div class="tcw-client-panel-head"><h2>{{ __('website.client.upcoming_deadlines') }}</h2><a href="{{ route('user.projects') }}">{{ __('website.client.view_all') }}</a></div>
        @forelse($projects->take(3) as $project)
          <article><i class="far fa-calendar-alt"></i><div><strong>{{ $project->title_label }}</strong><span>{{ $project->due_at?->locale(app()->getLocale())->translatedFormat('M d, Y') ?: __('website.client.due_soon') }}</span></div><b>{{ __('website.client.days_left', ['days' => max(1, now()->diffInDays($project->due_at ?? now()->addDays(7), false))]) }}</b></article>
        @empty
          <article><i class="far fa-calendar-alt"></i><div><strong>{{ __('website.client.no_deadlines') }}</strong><span>{{ __('website.client.start_new_project') }}</span></div><b>{{ __('website.client.new') }}</b></article>
        @endforelse
      </section>

      <section class="tcw-client-panel tcw-bar-card">
        <div class="tcw-client-panel-head">
          <h2>{{ __('website.client.monthly_spending') }}</h2>
          <label class="tcw-activity-month-select">
            <select id="spendingYearSelect" aria-label="{{ __('website.client.select_year') }}">
              @foreach($spendingYears as $year)
                <option value="{{ $year['year'] }}">{{ $loop->first ? __('website.client.this_year') : $year['label'] }}</option>
              @endforeach
            </select>
            <i class="fas fa-chevron-down"></i>
          </label>
        </div>
        <div class="tcw-bar-chart" id="spendingChart" data-spending='@json($spendingYears)'>
          <div class="tcw-bar-total"><span>{{ __('website.client.total') }}</span><strong id="spendingTotal">AED 0</strong></div>
          <div class="tcw-bar-bars" id="spendingBars"></div>
        </div>
      </section>

      <section class="tcw-client-panel tcw-service-spend-card">
        <div class="tcw-client-panel-head"><h2>{{ __('website.client.service_spending') }}</h2></div>
        <div class="tcw-donut-wrap is-small">
          <div class="tcw-css-donut"></div>
          <div class="tcw-donut-legend">
            <p><i class="is-blue"></i>{{ __('website.client.web_development') }} <b>AED {{ number_format(max($totalSpent, 5450)) }}</b></p>
            <p><i class="is-purple"></i>{{ __('website.client.seo_services') }} <b>AED 2,850</b></p>
            <p><i class="is-orange"></i>{{ __('website.client.ui_design') }} <b>AED 2,100</b></p>
            <p><i class="is-cyan"></i>{{ __('website.client.digital_marketing') }} <b>AED 1,450</b></p>
          </div>
        </div>
      </section>

      <section class="tcw-client-panel tcw-quick-actions-card">
        <div class="tcw-client-panel-head"><h2>{{ __('website.client.quick_actions') }}</h2></div>
        <div>
          <a href="{{ route('website.contact') }}"><i class="fas fa-plus-circle"></i><span>{{ __('website.client.new_request') }}</span></a>
          <a href="{{ route('website.quote-generator') }}"><i class="far fa-file-pdf"></i><span>{{ __('website.client.request_quote') }}</span></a>
          <a href="{{ route('website.offers') }}"><i class="fas fa-tags"></i><span>{{ __('website.client.browse_offers') }}</span></a>
          <a href="{{ route('user.projects') }}"><i class="fas fa-chart-line"></i><span>{{ __('website.client.track_projects') }}</span></a>
          <a href="{{ route('user.orders') }}"><i class="far fa-file-alt"></i><span>{{ __('website.client.view_invoices') }}</span></a>
          <a href="{{ route('user.support-chat') }}"><i class="fas fa-headset"></i><span>{{ __('website.client.chat') }}</span></a>
        </div>
      </section>
    </div>
  </section>

  @include('user.partials.client-mobile-nav')
</main>
@endsection

@push('js')
  @include('user.partials.client-shell-script')
  <script>
    (() => {
      const chart = document.getElementById('activityChart');
      const select = document.getElementById('activityMonthSelect');
      if (!chart || !select) return;

      const months = JSON.parse(chart.dataset.activity || '[]');
      const line = chart.querySelector('.tcw-activity-line');
      const area = chart.querySelector('.tcw-activity-area');
      const dots = chart.querySelector('.tcw-activity-dots');
      const tooltip = document.getElementById('activityTooltip');
      const label = document.getElementById('activityMonthLabel');
      const width = 360;
      const height = 180;
      const padX = 18;
      const padY = 18;

      const render = (key) => {
        const month = months.find((item) => item.key === key) || months[0];
        if (!month) return;

        const values = month.points || [];
        const max = Math.max(...values, 1);
        const step = values.length > 1 ? (width - padX * 2) / (values.length - 1) : 0;
        const points = values.map((value, index) => {
          const x = padX + (index * step);
          const y = height - padY - ((value / max) * (height - padY * 2));
          return [x, y, value, index + 1];
        });

        line.setAttribute('points', points.map(([x, y]) => `${x.toFixed(2)},${y.toFixed(2)}`).join(' '));
        area.setAttribute('d', points.length
          ? `M ${points[0][0].toFixed(2)} ${height - padY} L ${points.map(([x, y]) => `${x.toFixed(2)} ${y.toFixed(2)}`).join(' L ')} L ${points[points.length - 1][0].toFixed(2)} ${height - padY} Z`
          : '');
        dots.innerHTML = points
          .filter((point) => point[2] > 0)
          .map(([x, y, value, day]) => `<circle cx="${x.toFixed(2)}" cy="${y.toFixed(2)}" r="${value === month.peakCount ? 4.5 : 3}" data-day="${day}" data-count="${value}" />`)
          .join('');

        tooltip.innerHTML = `${month.peakLabel}<br>${month.peakCount} {{ __('website.client.activities') }}`;
        tooltip.style.left = `${Math.min(72, Math.max(18, (month.peakDay / values.length) * 100))}%`;
        label.textContent = `${month.label} · ${month.total} {{ __('website.client.activities') }}`;
      };

      select.addEventListener('change', () => render(select.value));
      render(select.value);
    })();
  </script>
  <script>
    (() => {
      const chart = document.getElementById('spendingChart');
      const select = document.getElementById('spendingYearSelect');
      const bars = document.getElementById('spendingBars');
      const total = document.getElementById('spendingTotal');
      if (!chart || !select || !bars || !total) return;

      const years = JSON.parse(chart.dataset.spending || '[]');
      const format = (amount, currency = 'AED') => `${currency} ${Number(amount || 0).toLocaleString()}`;

      const render = (yearValue) => {
        const year = years.find((item) => String(item.year) === String(yearValue)) || years[0];
        if (!year) return;

        const values = year.months || [];
        const max = Math.max(...values, 1);
        total.textContent = format(year.total, year.currency);
        bars.innerHTML = values.map((amount, index) => {
          const height = Math.max(6, Math.round((amount / max) * 100));
          const label = year.monthLabels[index] || '';
          return `<span title="${label}: ${format(amount, year.currency)}"><i style="--h:${height}%"></i><b>${label}</b></span>`;
        }).join('');
      };

      select.addEventListener('change', () => render(select.value));
      render(select.value);
    })();
  </script>
@endpush
