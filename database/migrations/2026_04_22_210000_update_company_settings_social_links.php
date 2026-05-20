<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->string('youtube')->nullable()->after('facebook');
            $table->string('tiktok')->nullable()->after('youtube');
            $table->string('linkedin')->nullable()->after('tiktok');
            $table->dropColumn('twitter');
        });
    }

    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->string('twitter')->nullable()->after('facebook');
            $table->dropColumn(['youtube', 'tiktok', 'linkedin']);
        });
    }
};
