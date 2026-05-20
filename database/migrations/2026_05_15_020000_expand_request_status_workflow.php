<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('service_requests')->where('status', 'pending')->update(['status' => 'pending_review']);
        DB::table('service_requests')->where('status', 'deal')->update(['status' => 'deal_in_progress']);
        DB::table('service_requests')->where('status', 'complete')->update(['status' => 'completed']);

        DB::table('quote_requests')->where('status', 'pending')->update(['status' => 'pending_review']);
        DB::table('quote_requests')->where('status', 'deal')->update(['status' => 'deal_in_progress']);
        DB::table('quote_requests')->where('status', 'complete')->update(['status' => 'completed']);
    }

    public function down(): void
    {
        DB::table('service_requests')->where('status', 'pending_review')->update(['status' => 'pending']);
        DB::table('service_requests')->where('status', 'deal_in_progress')->update(['status' => 'deal']);
        DB::table('service_requests')->where('status', 'completed')->update(['status' => 'complete']);

        DB::table('quote_requests')->where('status', 'pending_review')->update(['status' => 'pending']);
        DB::table('quote_requests')->where('status', 'deal_in_progress')->update(['status' => 'deal']);
        DB::table('quote_requests')->where('status', 'completed')->update(['status' => 'complete']);
    }
};
