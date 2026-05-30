<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use App\Models\AgencyProject;
use App\Models\AgencySubscription;
use App\Models\OfferOrder;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $user = $request->user();
        $serviceRequests = ServiceRequest::where('user_id', $user->id)->latest()->get();
        $quoteRequests = QuoteRequest::with('service')->where('user_id', $user->id)->latest()->get();
        $orders = OfferOrder::with('offer')->where('user_id', $user->id)->latest()->get();
        $projects = AgencyProject::with('order.offer')->where('user_id', $user->id)->latest()->get();
        $subscriptions = AgencySubscription::with('offer')->where('user_id', $user->id)->latest()->get();
        $latestServiceRequest = $serviceRequests->first();
        $latestQuoteRequest = $quoteRequests->first();
        $allRequests = $serviceRequests->concat($quoteRequests);
        $statusCounts = collect(array_keys(ServiceRequest::STATUSES))
            ->mapWithKeys(fn (string $status) => [$status => $allRequests->where('status', $status)->count()]);
        $requestOverview = $this->requestOverview($statusCounts, $allRequests->count());
        $notifications = $user->notifications()->latest()->take(8)->get();
        $headerNotifications = $notifications;
        $unreadNotificationsCount = $user->unreadNotifications()->count();
        $recentRequests = $serviceRequests
            ->map(fn (ServiceRequest $serviceRequest) => [
                'type' => 'service',
                'title' => $serviceRequest->service_label,
                'subtitle' => $serviceRequest->company_name,
                'date' => $serviceRequest->created_at,
            ])
            ->concat($quoteRequests->map(fn (QuoteRequest $quoteRequest) => [
                'type' => 'quote',
                'title' => $quoteRequest->reference,
                'subtitle' => $quoteRequest->service_label,
                'date' => $quoteRequest->created_at,
            ]))
            ->sortByDesc('date')
            ->take(5)
            ->values();
        $activityMonths = $this->activityMonths($serviceRequests, $quoteRequests, $orders, $projects);
        $spendingYears = $this->spendingYears($orders, $subscriptions);

        return view('user.dashboard', compact(
            'serviceRequests',
            'quoteRequests',
            'latestServiceRequest',
            'latestQuoteRequest',
            'statusCounts',
            'requestOverview',
            'notifications',
            'headerNotifications',
            'unreadNotificationsCount',
            'recentRequests',
            'orders',
            'projects',
            'subscriptions',
            'activityMonths',
            'spendingYears'
        ));
    }

    public function serviceRequests(Request $request)
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $user = $request->user();

        return view('user.service-requests', [
            'serviceRequests' => ServiceRequest::where('user_id', $user->id)->latest()->paginate(10),
            ...$this->sidebarData($user),
        ]);
    }

    public function quoteRequests(Request $request)
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $user = $request->user();

        return view('user.quote-requests', [
            'quoteRequests' => QuoteRequest::with('service')->where('user_id', $user->id)->latest()->paginate(10),
            ...$this->sidebarData($user),
        ]);
    }

    public function notifications(Request $request)
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $user = $request->user();
        $user->unreadNotifications->markAsRead();

        return view('user.notifications', [
            'notifications' => $user->notifications()->latest()->paginate(12),
            ...$this->sidebarData($user),
        ]);
    }

    public function orders(Request $request)
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $user = $request->user();

        return view('user.orders', [
            'orders' => OfferOrder::with('offer')->where('user_id', $user->id)->latest()->paginate(10),
            ...$this->sidebarData($user),
        ]);
    }

    public function subscriptions(Request $request)
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $user = $request->user();

        return view('user.subscriptions', [
            'subscriptions' => AgencySubscription::with('offer')->where('user_id', $user->id)->latest()->paginate(10),
            ...$this->sidebarData($user),
        ]);
    }

    protected function sidebarData($user): array
    {
        return [
            'serviceRequestsCount' => ServiceRequest::where('user_id', $user->id)->count(),
            'quoteRequestsCount' => QuoteRequest::where('user_id', $user->id)->count(),
            'ordersCount' => OfferOrder::where('user_id', $user->id)->count(),
            'projectsCount' => AgencyProject::where('user_id', $user->id)->count(),
            'subscriptionsCount' => AgencySubscription::where('user_id', $user->id)->count(),
            'unreadNotificationsCount' => $user->unreadNotifications()->count(),
            'headerNotifications' => $user->notifications()->latest()->take(8)->get(),
        ];
    }

    protected function activityMonths($serviceRequests, $quoteRequests, $orders, $projects): array
    {
        $events = collect()
            ->merge($serviceRequests->map(fn ($item) => ['date' => $item->created_at, 'type' => 'Service request']))
            ->merge($quoteRequests->map(fn ($item) => ['date' => $item->created_at, 'type' => 'Quote request']))
            ->merge($orders->map(fn ($item) => ['date' => $item->created_at, 'type' => 'Order']))
            ->merge($projects->map(fn ($item) => ['date' => $item->created_at, 'type' => 'Project']));

        return collect(range(0, 11))
            ->map(function (int $offset) use ($events) {
                $month = now()->copy()->subMonths($offset)->startOfMonth();
                $daysInMonth = $month->daysInMonth;
                $counts = array_fill(1, $daysInMonth, 0);

                $events
                    ->filter(fn ($event) => $event['date'] && $event['date']->isSameMonth($month))
                    ->each(function ($event) use (&$counts) {
                        $counts[(int) $event['date']->format('j')]++;
                    });

                $peakCount = max($counts ?: [0]);
                $peakDay = array_search($peakCount, $counts, true) ?: 1;

                return [
                    'key' => $month->format('Y-m'),
                    'label' => $month->copy()->locale(app()->getLocale())->translatedFormat('F Y'),
                    'shortLabel' => $month->copy()->locale(app()->getLocale())->translatedFormat('M Y'),
                    'total' => array_sum($counts),
                    'peakDay' => $peakDay,
                    'peakLabel' => $month->copy()->day($peakDay)->locale(app()->getLocale())->translatedFormat('M j'),
                    'peakCount' => $peakCount,
                    'points' => array_values($counts),
                ];
            })
            ->values()
            ->all();
    }

    protected function requestOverview($statusCounts, int $totalRequests): array
    {
        $colors = ['#2563eb', '#9333ea', '#f59e0b', '#14b8a6', '#22c55e', '#06b6d4', '#ec4899', '#64748b', '#38bdf8', '#8b5cf6'];
        $cursor = 0;

        $segments = collect(ServiceRequest::STATUSES)
            ->map(function (string $label, string $status) use ($statusCounts, $totalRequests, $colors, &$cursor) {
                $count = (int) ($statusCounts[$status] ?? 0);
                $percent = $totalRequests > 0 ? round(($count / $totalRequests) * 100, 1) : 0;
                $start = $cursor;
                $cursor += $percent;

                return [
                    'status' => $status,
                    'label' => __("website.client.status_labels.{$status}"),
                    'count' => $count,
                    'percent' => $percent,
                    'start' => $start,
                    'end' => $cursor,
                    'color' => $colors[$cursor === 0 ? 0 : (count($colors) + array_search($status, array_keys(ServiceRequest::STATUSES), true)) % count($colors)],
                ];
            });

        $visibleSegments = $segments->filter(fn (array $segment) => $segment['count'] > 0)->values();

        if ($visibleSegments->isEmpty()) {
            $visibleSegments = $segments->take(4)->values();
            $gradient = 'conic-gradient(rgba(37, 99, 235, 0.22) 0 100%)';
        } else {
            $running = 0;
            $visibleSegments = $visibleSegments
                ->map(function (array $segment, int $index) use (&$running, $totalRequests, $colors, $visibleSegments) {
                    $start = $running;
                    $running += ($segment['count'] / max($totalRequests, 1)) * 100;
                    $segment['start'] = round($start, 2);
                    $segment['end'] = $index === $visibleSegments->count() - 1 ? 100 : round($running, 2);
                    $segment['color'] = $colors[$index % count($colors)];

                    return $segment;
                })
                ->values();

            $gradient = 'conic-gradient('.$visibleSegments
                ->map(fn (array $segment) => "{$segment['color']} {$segment['start']}% {$segment['end']}%")
                ->implode(', ').')';
        }

        return [
            'total' => $totalRequests,
            'segments' => $visibleSegments,
            'gradient' => $gradient,
        ];
    }

    protected function spendingYears($orders, $subscriptions): array
    {
        $events = collect()
            ->merge($orders->map(fn ($order) => [
                'date' => $order->created_at,
                'amount' => (int) $order->amount,
            ]))
            ->merge($subscriptions->map(fn ($subscription) => [
                'date' => $subscription->starts_at ?: $subscription->created_at,
                'amount' => (int) $subscription->amount,
            ]));

        $years = $events
            ->pluck('date')
            ->filter()
            ->map(fn ($date) => (int) $date->format('Y'))
            ->push((int) now()->format('Y'))
            ->unique()
            ->sortDesc()
            ->values();

        return $years
            ->map(function (int $year) use ($events) {
                $monthly = collect(range(1, 12))
                    ->map(function (int $month) use ($events, $year) {
                        return $events
                            ->filter(fn ($event) => $event['date'] && (int) $event['date']->format('Y') === $year && (int) $event['date']->format('n') === $month)
                            ->sum('amount');
                    })
                    ->values();

                return [
                    'year' => $year,
                    'label' => (string) $year,
                    'total' => $monthly->sum(),
                    'currency' => 'AED',
                    'months' => $monthly->all(),
                    'monthLabels' => collect(range(1, 12))
                        ->map(fn (int $month) => now()->month($month)->locale(app()->getLocale())->translatedFormat('M'))
                        ->all(),
                ];
            })
            ->values()
            ->all();
    }
}
