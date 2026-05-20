<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyBlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'How Smart Campaigns Build Better Leads',
                'category' => 'Marketing',
                'image' => 'website/assets/img/app-landing/post1.jpg',
            ],
            [
                'title' => 'Design Systems That Make Brands Easier to Trust',
                'category' => 'Branding',
                'image' => 'website/assets/img/app-landing/post2.jpg',
            ],
            [
                'title' => 'Why Fast Landing Pages Convert More Visitors',
                'category' => 'Web Design',
                'image' => 'website/assets/img/app-landing/post3.jpg',
            ],
            [
                'title' => 'Simple SEO Wins for Service Businesses',
                'category' => 'SEO',
                'image' => 'website/assets/img/app-landing/post4.jpg',
            ],
            [
                'title' => 'Content Ideas That Keep Audiences Engaged',
                'category' => 'Content',
                'image' => 'website/assets/img/app-landing/post5.jpg',
            ],
        ];

        foreach ($blogs as $index => $blog) {
            Blog::updateOrCreate(
                ['slug' => Str::slug($blog['title'])],
                [
                    'title' => $blog['title'],
                    'author_name' => 'The Click Wise',
                    'category' => $blog['category'],
                    'author_image' => null,
                    'featured_image' => $blog['image'],
                    'excerpt' => 'A short practical guide for improving digital presence and campaign performance.',
                    'content' => 'This is dummy blog content for previewing the website blog slider. Replace it from the admin dashboard with real article content when ready.',
                    'author_bio' => 'The Click Wise team writes about growth, design, SEO, and performance marketing.',
                    'views' => 0,
                    'is_active' => true,
                    'published_at' => now()->subDays(5 - $index),
                ]
            );
        }
    }
}
