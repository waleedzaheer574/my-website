<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('company_settings', 'whatsapp_number')) {
                $table->string('whatsapp_number')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('company_settings', 'quote_link')) {
                $table->string('quote_link')->nullable()->after('whatsapp_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            if (Schema::hasColumn('company_settings', 'quote_link')) {
                $table->dropColumn('quote_link');
            }

            if (Schema::hasColumn('company_settings', 'whatsapp_number')) {
                $table->dropColumn('whatsapp_number');
            }
        });
    }
};
