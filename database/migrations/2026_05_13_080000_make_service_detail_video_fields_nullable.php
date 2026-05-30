<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_details', function (Blueprint $table) {
            $table->string('video_thumbnail')->nullable()->change();
            $table->string('video_url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('service_details', function (Blueprint $table) {
            $table->string('video_thumbnail')->nullable(false)->change();
            $table->string('video_url')->nullable(false)->change();
        });
    }
};
