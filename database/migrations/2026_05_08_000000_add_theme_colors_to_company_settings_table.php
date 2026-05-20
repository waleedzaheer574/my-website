<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('company_settings', 'theme_primary_color')) {
                $table->string('theme_primary_color', 7)->default('#38BDF8')->after('linkedin');
            }

            if (! Schema::hasColumn('company_settings', 'theme_secondary_color')) {
                $table->string('theme_secondary_color', 7)->default('#22C55E')->after('theme_primary_color');
            }

            if (! Schema::hasColumn('company_settings', 'theme_dark_color')) {
                $table->string('theme_dark_color', 7)->default('#020617')->after('theme_secondary_color');
            }
        });
    }

    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            if (Schema::hasColumn('company_settings', 'theme_dark_color')) {
                $table->dropColumn('theme_dark_color');
            }

            if (Schema::hasColumn('company_settings', 'theme_secondary_color')) {
                $table->dropColumn('theme_secondary_color');
            }

            if (Schema::hasColumn('company_settings', 'theme_primary_color')) {
                $table->dropColumn('theme_primary_color');
            }
        });
    }
};
