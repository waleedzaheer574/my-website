<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_token')->unique();
            $table->string('reference')->unique();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('service_title');
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone')->nullable();
            $table->string('company_name')->nullable();
            $table->string('budget_range');
            $table->string('timeline')->nullable();
            $table->text('requirements');
            $table->string('currency', 8)->default('USD');
            $table->unsignedInteger('estimated_min');
            $table->unsignedInteger('estimated_max');
            $table->json('deliverables')->nullable();
            $table->json('assumptions')->nullable();
            $table->json('next_steps')->nullable();
            $table->string('status')->default('new');
            $table->timestamp('viewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
