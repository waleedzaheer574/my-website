<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CompanySetting;
use App\Models\Logo;
use App\Models\AgencySubscription;
use App\Models\Offer;
use App\Models\OfferOrder;
use App\Models\QuoteRequest;
use App\Models\AgencyProject;
use App\Models\SupportConversation;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'services' => Service::count(),
            'service_details' => ServiceDetail::count(),
            'blogs' => Blog::count(),
            'logos' => Logo::count(),
            'offers' => Offer::count(),
            'orders' => OfferOrder::count(),
            'projects' => AgencyProject::count(),
            'subscriptions' => AgencySubscription::count(),
            'paid_orders_total' => OfferOrder::where('payment_status', 'paid')->sum('amount'),
            'service_requests' => ServiceRequest::count(),
            'settings' => CompanySetting::count(),
        ];

        $months = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = now()->subMonths($monthsAgo);

            return [
                'key' => $date->format('Y-m'),
                'label' => $date->format('M'),
                'services' => 0,
                'blogs' => 0,
                'requests' => 0,
                'orders' => 0,
            ];
        })->values();

        $serviceSeries = $this->getMonthlySeries(new Service());
        $blogSeries = $this->getMonthlySeries(new Blog());
        $requestSeries = $this->getMonthlySeries(new ServiceRequest());
        $orderSeries = $this->getMonthlySeries(new OfferOrder());

        $monthlyActivity = $months->map(function ($month) use ($serviceSeries, $blogSeries, $requestSeries, $orderSeries) {
            return [
                'label' => $month['label'],
                'services' => (int) ($serviceSeries[$month['key']] ?? 0),
                'blogs' => (int) ($blogSeries[$month['key']] ?? 0),
                'requests' => (int) ($requestSeries[$month['key']] ?? 0),
                'orders' => (int) ($orderSeries[$month['key']] ?? 0),
            ];
        });

        $maxActivity = max(
            1,
            $monthlyActivity->max('services'),
            $monthlyActivity->max('blogs'),
            $monthlyActivity->max('requests'),
            $monthlyActivity->max('orders')
        );

        $recentBlogs = Blog::latest()->take(4)->get();
        $recentServices = Service::latest()->take(5)->get();
        $recentRequests = ServiceRequest::latest()->take(4)->get();
        $recentOrders = OfferOrder::with(['user', 'offer'])->latest()->take(4)->get();
        $recentProjects = AgencyProject::with(['user', 'order.offer'])->latest()->take(4)->get();
        $topServices = ServiceRequest::selectRaw('service_type, COUNT(*) as aggregate')
            ->groupBy('service_type')
            ->orderByDesc('aggregate')
            ->take(4)
            ->get();
        $topServicesTotal = max(1, (int) $topServices->sum('aggregate'));
        $supportOverview = [
            'active' => class_exists(SupportConversation::class) ? SupportConversation::count() : 0,
            'open' => QuoteRequest::whereIn('status', ['submitted', 'pending_review', 'in_discussion'])->count(),
            'resolved' => ServiceRequest::where('status', 'completed')->count(),
        ];

        $contentTotal = max(1, $stats['services'] + $stats['service_details'] + $stats['blogs'] + $stats['service_requests'] + $stats['logos']);
        $contentMix = [
            [
                'label' => 'Services',
                'count' => $stats['services'],
                'width' => round(($stats['services'] / $contentTotal) * 100, 1),
                'color' => '#38BDF8',
            ],
            [
                'label' => 'Service Details',
                'count' => $stats['service_details'],
                'width' => round(($stats['service_details'] / $contentTotal) * 100, 1),
                'color' => '#8B5CF6',
            ],
            [
                'label' => 'Blogs',
                'count' => $stats['blogs'],
                'width' => round(($stats['blogs'] / $contentTotal) * 100, 1),
                'color' => '#2563eb',
            ],
            [
                'label' => 'Service Requests',
                'count' => $stats['service_requests'],
                'width' => round(($stats['service_requests'] / $contentTotal) * 100, 1),
                'color' => '#f59e0b',
            ],
            [
                'label' => 'Logos',
                'count' => $stats['logos'],
                'width' => round(($stats['logos'] / $contentTotal) * 100, 1),
                'color' => '#22c55e',
            ],
        ];

        return view('dashboard.index', compact(
            'stats',
            'monthlyActivity',
            'maxActivity',
            'recentBlogs',
            'recentServices',
            'recentRequests',
            'recentOrders',
            'recentProjects',
            'topServices',
            'topServicesTotal',
            'supportOverview',
            'contentMix'
        ));
    }

    protected function getMonthlySeries($model)
    {
        $driver = DB::connection()->getDriverName();
        $monthExpression = match ($driver) {
            'sqlite' => "strftime('%Y-%m', created_at)",
            default => "DATE_FORMAT(created_at, '%Y-%m')",
        };

        return $model::selectRaw("$monthExpression as month_key, COUNT(*) as aggregate")
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month_key')
            ->pluck('aggregate', 'month_key');
    }
}
