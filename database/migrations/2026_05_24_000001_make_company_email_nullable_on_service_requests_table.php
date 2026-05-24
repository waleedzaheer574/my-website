<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('company_email')->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('service_requests')
            ->whereNull('company_email')
            ->update(['company_email' => 'unknown@ai-call.local']);

        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('company_email')->nullable(false)->change();
        });
    }
};
