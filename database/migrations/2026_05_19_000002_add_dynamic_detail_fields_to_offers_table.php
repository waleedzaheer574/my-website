<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->text('detail_overview')->nullable()->after('description');
            $table->string('hero_visual_title')->nullable()->after('detail_overview');
            $table->json('overview_items')->nullable()->after('addons');
            $table->json('detail_features')->nullable()->after('overview_items');
            $table->json('tech_stack')->nullable()->after('detail_features');
            $table->json('delivery_timeline')->nullable()->after('tech_stack');
            $table->json('faqs')->nullable()->after('delivery_timeline');
            $table->json('why_choose')->nullable()->after('faqs');
        });
    }

    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn([
                'detail_overview',
                'hero_visual_title',
                'overview_items',
                'detail_features',
                'tech_stack',
                'delivery_timeline',
                'faqs',
                'why_choose',
            ]);
        });
    }
};
