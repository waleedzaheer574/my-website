<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CompanySetting;
use App\Models\Logo;
use App\Models\Offer;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\Service;
use App\Models\WhyNexa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function home()
    {
        $logos = Logo::latest()->get();
        $services = Service::with('detail')->orderBy('order')->latest()->get();
        $reviews = Review::where('is_active', true)
            ->where('media_type', 'text')
            ->orderBy('sort_order')
            ->latest()
            ->get();
        $homePortfolios = Portfolio::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->latest()
            ->take(6)
            ->get();

        if ($homePortfolios->isEmpty()) {
            $homePortfolios = Portfolio::where('is_active', true)
                ->orderBy('sort_order')
                ->latest()
                ->take(6)
                ->get();
        }

        $latestBlogs = Blog::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->latest()
            ->get();

        $whyNexas = WhyNexa::where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->take(3)
            ->get();
        $offers = Offer::where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->take(4)
            ->get();

        return view('website.home', compact('latestBlogs', 'logos', 'services', 'reviews', 'homePortfolios', 'whyNexas', 'offers'));
    }
    public function about()
    {
        $services = Service::with('detail')->latest()->get();

        $aboutPortfolios = Portfolio::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->latest()
            ->take(6)
            ->get();

        if ($aboutPortfolios->isEmpty()) {
            $aboutPortfolios = Portfolio::where('is_active', true)
                ->orderBy('sort_order')
                ->latest()
                ->take(6)
                ->get();
        }

        $reviews = Review::where('is_active', true)
            ->where('media_type', 'text')
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('website.about', compact('services', 'aboutPortfolios', 'reviews'));
    }

    public function contact()
    {
        $services = Service::with('detail')->latest()->get();
        $companySetting = CompanySetting::latest()->first();

        return view('website.contact', compact('services', 'companySetting'));
    }

    public function testimonials()
    {
        $reviews = Review::where('is_active', true)
            ->where('media_type', 'text')
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('website.testimonials', compact('reviews'));
    }

    public function page($page)
    {
        if (view()->exists('website.'.$page)) {
            return view('website.'.$page);
        }
        abort(404);
    }
}
