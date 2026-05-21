<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('source')->default('website')->after('status');
            $table->string('budget')->nullable()->after('source');
            $table->text('requirement')->nullable()->after('budget');
            $table->string('vapi_call_id')->nullable()->after('requirement');
            $table->string('call_status')->nullable()->after('vapi_call_id');
            $table->text('call_summary')->nullable()->after('call_status');
            $table->longText('call_transcript')->nullable()->after('call_summary');
            $table->json('raw_payload')->nullable()->after('call_transcript');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn([
                'source',
                'budget',
                'requirement',
                'vapi_call_id',
                'call_status',
                'call_summary',
                'call_transcript',
                'raw_payload',
            ]);
        });
    }
};
