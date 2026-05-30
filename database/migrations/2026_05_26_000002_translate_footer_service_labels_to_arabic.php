<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('services')
            ->where('service_title_ar', 'تطوير ERP وCRM')
            ->update(['service_title_ar' => 'تطوير أنظمة إدارة الموارد والعملاء']);

        DB::table('services')
            ->where('service_title_ar', 'خدمات السحابة وDevOps')
            ->update(['service_title_ar' => 'خدمات السحابة والتطوير التشغيلي']);
    }

    public function down(): void
    {
        DB::table('services')
            ->where('service_title_ar', 'تطوير أنظمة إدارة الموارد والعملاء')
            ->update(['service_title_ar' => 'تطوير ERP وCRM']);

        DB::table('services')
            ->where('service_title_ar', 'خدمات السحابة والتطوير التشغيلي')
            ->update(['service_title_ar' => 'خدمات السحابة وDevOps']);
    }
};
