<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyIndustrySeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
            ['Real Estate', 'Lead generation funnels, premium listing pages, and local SEO campaigns that help properties move faster.'],
            ['Healthcare', 'Trust-first websites, appointment journeys, and clear communication for clinics and care brands.'],
            ['E-commerce', 'Conversion-focused storefronts, product storytelling, and retention strategies for online growth.'],
            ['Education', 'Enrollment campaigns, course landing pages, and better digital experiences for learners.'],
            ['Finance', 'Professional brand systems and performance marketing that reinforce clarity and credibility.'],
            ['Hospitality', 'Campaigns and websites designed to turn attention into bookings, visits, and repeat business.'],
            ['Automotive', 'Digital campaigns, inventory landing pages, and local search systems for dealerships and auto brands.'],
            ['Legal Services', 'Authority-building websites and lead funnels for law firms, consultants, and advisory practices.'],
            ['Construction', 'Project-led portfolios, quote request funnels, and local campaigns for builders and contractors.'],
            ['Fitness & Wellness', 'Membership campaigns, class booking journeys, and retention content for wellness brands.'],
            ['SaaS & Technology', 'Product pages, onboarding funnels, and conversion campaigns for software and tech teams.'],
            ['Food & Beverage', 'Menu experiences, local SEO, and booking campaigns for restaurants, cafes, and food brands.'],
            ['Travel & Tourism', 'Destination pages, package campaigns, and booking journeys built for high-intent visitors.'],
            ['Nonprofits', 'Donation pages, awareness campaigns, and clear storytelling for community-focused organizations.'],
            ['Retail', 'Promotion-led campaigns, product discovery pages, and customer retention flows for retail growth.'],
        ];

        foreach ($industries as $index => [$title, $description]) {
            Industry::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'description' => $description,
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }
}
