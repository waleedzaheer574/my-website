<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('why_nexas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        $items = [
            ['We Understand your Goals', 'We start by learning your business goals, customers, and growth targets before building the right digital plan.'],
            ['We Enhance your Digital Strategy', 'Our team connects design, SEO, content, and paid campaigns so every channel works toward measurable performance.'],
            ['We Build Lasting Success', 'We focus on repeatable systems, clear reporting, and long-term growth instead of short-lived marketing moments.'],
        ];

        foreach ($items as $index => [$title, $description]) {
            DB::table('why_nexas')->insert([
                'title' => $title,
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
        Schema::dropIfExists('why_nexas');
    }
};
