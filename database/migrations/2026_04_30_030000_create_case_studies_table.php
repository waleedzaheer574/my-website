<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('image')->nullable();
            $table->text('summary')->nullable();
            $table->string('result')->nullable();
            $table->string('cta_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        $caseStudies = [
            [
                'Luxury Real Estate Launch',
                'Real Estate',
                'Positioned a high-end property brand with a focused campaign system that improved qualified lead volume.',
                'Qualified leads up 42%',
            ],
            [
                'Healthcare Lead Funnel',
                'Healthcare',
                'Redesigned the acquisition path for a clinic brand to make trust, booking, and follow-up feel simpler.',
                'Bookings up 31%',
            ],
            [
                'E-commerce Retention Push',
                'E-commerce',
                'Combined paid ads, lifecycle email, and landing page improvements to increase repeat purchases.',
                'Repeat sales up 27%',
            ],
            [
                'SaaS Trial Activation',
                'Technology',
                'Improved the product story and signup flow so trial users reached activation faster.',
                'Trial activation up 36%',
            ],
            [
                'Education Enrollment Campaign',
                'Education',
                'Built dedicated landing pages and retargeting content for a seasonal admissions push.',
                'Applications up 48%',
            ],
            [
                'Hospitality Booking Funnel',
                'Hospitality',
                'Created a mobile-first booking journey and local search campaign for a premium venue.',
                'Direct bookings up 29%',
            ],
            [
                'Legal Services Local SEO',
                'Legal',
                'Strengthened local visibility and service page clarity for a growing advisory practice.',
                'Organic inquiries up 34%',
            ],
            [
                'Fitness Membership Growth',
                'Fitness',
                'Launched a campaign system for memberships, class trials, and automated follow-up.',
                'Membership leads up 40%',
            ],
        ];

        foreach ($caseStudies as $index => [$title, $category, $summary, $result]) {
            DB::table('case_studies')->insert([
                'title' => $title,
                'slug' => Str::slug($title),
                'category' => $category,
                'summary' => $summary,
                'result' => $result,
                'cta_url' => url('/contact'),
                'sort_order' => $index,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};
