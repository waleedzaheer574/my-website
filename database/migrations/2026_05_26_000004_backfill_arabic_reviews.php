<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $reviews = [
            1 => ['designation_ar' => 'مسؤول الأداء', 'badge_ar' => 'مميز', 'review_text_ar' => 'مراجعة فيديو تجريبية لمعاينة شريط آراء العملاء في الصفحة الرئيسية.'],
            2 => ['designation_ar' => 'مديرة العلامة التجارية', 'badge_ar' => 'جديد', 'review_text_ar' => 'مراجعة فيديو تجريبية لمعاينة شريط آراء العملاء في الصفحة الرئيسية.'],
            3 => ['designation_ar' => 'مدير التسويق', 'badge_ar' => 'نمو', 'review_text_ar' => 'مراجعة فيديو تجريبية لمعاينة شريط آراء العملاء في الصفحة الرئيسية.'],
            4 => ['designation_ar' => 'المؤسسة', 'badge_ar' => 'استراتيجية', 'review_text_ar' => 'مراجعة فيديو تجريبية لمعاينة شريط آراء العملاء في الصفحة الرئيسية.'],
            5 => ['designation_ar' => 'مسؤول العمليات', 'badge_ar' => 'إبداعي', 'review_text_ar' => 'مراجعة فيديو تجريبية لمعاينة شريط آراء العملاء في الصفحة الرئيسية.'],
        ];

        foreach ($reviews as $id => $translation) {
            DB::table('reviews')->where('id', $id)->update($translation);
        }
    }

    public function down(): void
    {
        DB::table('reviews')->whereIn('id', [1, 2, 3, 4, 5])->update([
            'designation_ar' => null,
            'badge_ar' => null,
            'review_text_ar' => null,
        ]);
    }
};
