<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class DummyReviewSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['Awais Khan', 'Website Design', 'Founder, Retail Brand', 'Multitechwave delivered a clean, fast website that made our services easier to understand and helped us receive better quality leads.', 0, true],
            ['Jessica Roy', 'SEO Growth', 'Brand Manager', 'Their SEO and content recommendations were practical, clear, and focused on results. We saw stronger search visibility within a few weeks.', 1, false],
            ['Michael Lee', 'Shopify', 'Ecommerce Director', 'Our Shopify store looks professional, loads quickly, and is much easier for customers to use. The process was smooth from start to finish.', 2, false],
            ['Sarah Khan', 'Branding', 'Startup Founder', 'The branding work gave our company a polished identity. Everything from colors to page layout finally feels consistent.', 3, false],
            ['Hamza Ali', 'Marketing', 'Operations Lead', 'They understood our business goals and turned them into clear campaigns, better landing pages, and measurable digital growth.', 4, false],
        ];

        foreach ($items as [$name, $badge, $designation, $reviewText, $sortOrder, $featured]) {
            Review::updateOrCreate(
                [
                    'client_name' => $name,
                    'media_type' => 'text',
                ],
                [
                    'designation' => $designation,
                    'badge' => $badge,
                    'review_text' => $reviewText,
                    'media_path' => '',
                    'poster_path' => null,
                    'is_featured' => $featured,
                    'is_active' => true,
                    'sort_order' => $sortOrder,
                ]
            );
        }
    }
}
