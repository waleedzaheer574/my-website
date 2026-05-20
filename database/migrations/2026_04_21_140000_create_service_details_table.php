<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('title_prefix')->nullable();
            $table->string('title_highlight')->nullable();
            $table->text('description')->nullable();
            $table->string('process_heading')->nullable();
            $table->string('process_one_title')->nullable();
            $table->text('process_one_text')->nullable();
            $table->string('process_two_title')->nullable();
            $table->text('process_two_text')->nullable();
            $table->string('process_three_title')->nullable();
            $table->text('process_three_text')->nullable();
            $table->string('primary_image')->nullable();
            $table->string('video_thumbnail')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_details');
    }
};
