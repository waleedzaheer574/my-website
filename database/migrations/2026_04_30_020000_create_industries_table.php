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
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        $industries = [
            ['Real Estate', 'Lead generation funnels, premium listing pages, and local SEO campaigns that help properties move faster.'],
            ['Healthcare', 'Trust-first websites, appointment journeys, and clear communication for clinics and care brands.'],
            ['E-commerce', 'Conversion-focused storefronts, product storytelling, and retention strategies for online growth.'],
            ['Education', 'Enrollment campaigns, course landing pages, and better digital experiences for learners.'],
            ['Finance', 'Professional brand systems and performance marketing that reinforce clarity and credibility.'],
            ['Hospitality', 'Campaigns and websites designed to turn attention into bookings, visits, and repeat business.'],
        ];

        foreach ($industries as $index => [$title, $description]) {
            DB::table('industries')->insert([
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => $description,
                'sort_order' => $index,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('industries');
    }
};
