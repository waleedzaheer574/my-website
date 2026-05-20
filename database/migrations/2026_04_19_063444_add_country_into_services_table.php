<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('services') && ! Schema::hasColumn('services', 'country')) {
            Schema::table('services', function (Blueprint $table) {
                $table->string('country')->nullable()->after('service_type');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('services') && Schema::hasColumn('services', 'country')) {
            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('country');
            });
        }
    }
};
