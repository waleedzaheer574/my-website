<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Offer;
use App\Models\Portfolio;
use App\Models\ServiceDetail;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $urls = collect([
            ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => url('/about'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()],
            ['loc' => route('website.services'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('website.industries'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()],
            ['loc' => route('website.case-studies'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()],
            ['loc' => route('website.portfolio'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('website.testimonials'), 'priority' => '0.6', 'changefreq' => 'monthly', 'lastmod' => now()],
            ['loc' => route('website.blog'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => route('website.offers'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()],
            ['loc' => url('/contact'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()],
            ['loc' => url('/privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly', 'lastmod' => now()],
            ['loc' => url('/terms'), 'priority' => '0.3', 'changefreq' => 'yearly', 'lastmod' => now()],
        ]);

        $serviceUrls = ServiceDetail::query()
            ->whereNotNull('slug')
            ->latest('updated_at')
            ->get()
            ->map(fn (ServiceDetail $serviceDetail) => [
                'loc' => route('website.service-details.show', $serviceDetail->slug),
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'lastmod' => $serviceDetail->updated_at,
            ]);

        $portfolioUrls = Portfolio::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->latest('updated_at')
            ->get()
            ->map(fn (Portfolio $portfolio) => [
                'loc' => route('website.portfolio-details.show', $portfolio->slug),
                'priority' => '0.7',
                'changefreq' => 'monthly',
                'lastmod' => $portfolio->updated_at,
            ]);

        $blogUrls = Blog::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->latest('updated_at')
            ->get()
            ->map(fn (Blog $blog) => [
                'loc' => route('website.blog-details.show', $blog->slug),
                'priority' => '0.7',
                'changefreq' => 'monthly',
                'lastmod' => $blog->updated_at ?: $blog->published_at,
            ]);

        $offerUrls = Offer::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->latest('updated_at')
            ->get()
            ->map(fn (Offer $offer) => [
                'loc' => route('website.offers.show', $offer->slug),
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'lastmod' => $offer->updated_at,
            ]);

        $urls = $urls->merge($serviceUrls)->merge($portfolioUrls)->merge($blogUrls)->merge($offerUrls);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.e($url['loc'])."</loc>\n";

            if (! empty($url['lastmod'])) {
                $xml .= '    <lastmod>'.e($url['lastmod']->toAtomString())."</lastmod>\n";
            }

            $xml .= '    <changefreq>'.e($url['changefreq'])."</changefreq>\n";
            $xml .= '    <priority>'.e($url['priority'])."</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
