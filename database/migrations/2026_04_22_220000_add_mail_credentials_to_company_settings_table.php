<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->string('smtp_email')->nullable()->after('email');
            $table->text('smtp_password')->nullable()->after('smtp_email');
            $table->string('notification_email')->nullable()->after('smtp_password');
        });
    }

    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn(['smtp_email', 'smtp_password', 'notification_email']);
        });
    }
};
