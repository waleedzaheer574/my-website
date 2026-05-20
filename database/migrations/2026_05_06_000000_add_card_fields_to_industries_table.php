<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('industries', function (Blueprint $table) {
            $table->string('category')->nullable()->after('slug');
            $table->string('result')->nullable()->after('description');
            $table->string('cta_url')->nullable()->after('result');
        });
    }

    public function down(): void
    {
        Schema::table('industries', function (Blueprint $table) {
            $table->dropColumn(['category', 'result', 'cta_url']);
        });
    }
};
