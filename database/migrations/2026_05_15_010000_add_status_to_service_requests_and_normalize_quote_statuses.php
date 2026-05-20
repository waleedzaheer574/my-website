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
            $table->string('status')->default('pending')->after('service_type');
        });

        DB::table('quote_requests')
            ->whereIn('status', ['new', 'submitted'])
            ->update(['status' => 'pending']);
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
