<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('service_title_ar')->nullable()->after('service_title');
            $table->text('service_description_ar')->nullable()->after('service_description');
        });

        Schema::table('service_details', function (Blueprint $table) {
            $table->string('title_prefix_ar')->nullable()->after('title_prefix');
            $table->string('title_highlight_ar')->nullable()->after('title_highlight');
            $table->text('description_ar')->nullable()->after('description');
            $table->string('process_heading_ar')->nullable()->after('process_heading');
            $table->string('process_one_title_ar')->nullable()->after('process_one_title');
            $table->text('process_one_text_ar')->nullable()->after('process_one_text');
            $table->string('process_two_title_ar')->nullable()->after('process_two_title');
            $table->text('process_two_text_ar')->nullable()->after('process_two_text');
            $table->string('process_three_title_ar')->nullable()->after('process_three_title');
            $table->text('process_three_text_ar')->nullable()->after('process_three_text');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title');
            $table->string('category_ar')->nullable()->after('category');
            $table->text('excerpt_ar')->nullable()->after('excerpt');
            $table->longText('content_ar')->nullable()->after('content');
            $table->text('author_bio_ar')->nullable()->after('author_bio');
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title');
            $table->string('category_ar')->nullable()->after('category');
            $table->string('tags_ar')->nullable()->after('tags');
            $table->string('duration_ar')->nullable()->after('duration');
            $table->text('short_description_ar')->nullable()->after('short_description');
            $table->text('description_ar')->nullable()->after('description');
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title');
            $table->string('category_ar')->nullable()->after('category');
            $table->text('description_ar')->nullable()->after('description');
            $table->text('detail_overview_ar')->nullable()->after('detail_overview');
            $table->string('hero_visual_title_ar')->nullable()->after('hero_visual_title');
            $table->json('features_ar')->nullable()->after('features');
            $table->json('overview_items_ar')->nullable()->after('overview_items');
            $table->json('detail_features_ar')->nullable()->after('detail_features');
            $table->json('delivery_timeline_ar')->nullable()->after('delivery_timeline');
            $table->json('faqs_ar')->nullable()->after('faqs');
            $table->json('why_choose_ar')->nullable()->after('why_choose');
        });

        Schema::table('industries', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title');
            $table->string('category_ar')->nullable()->after('category');
            $table->text('description_ar')->nullable()->after('description');
            $table->string('result_ar')->nullable()->after('result');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->string('designation_ar')->nullable()->after('designation');
            $table->string('badge_ar')->nullable()->after('badge');
            $table->text('review_text_ar')->nullable()->after('review_text');
        });

        Schema::table('case_studies', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title');
            $table->string('category_ar')->nullable()->after('category');
            $table->text('summary_ar')->nullable()->after('summary');
            $table->string('result_ar')->nullable()->after('result');
        });

        Schema::table('why_nexas', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title');
            $table->text('description_ar')->nullable()->after('description');
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->string('question_ar')->nullable()->after('question');
            $table->text('answer_ar')->nullable()->after('answer');
        });

        $offerTranslations = [
            '5-page-dynamic-website' => [
                'title_ar' => 'موقع ديناميكي من 5 صفحات',
                'category_ar' => 'تطوير المواقع',
                'description_ar' => 'موقع أعمال احترافي مع محتوى قابل للتعديل وصفحات متجاوبة ومسار واضح لاستقبال الطلبات.',
                'features_ar' => ['5 صفحات متجاوبة', 'محتوى قابل للتعديل', 'نموذج تواصل', 'تهيئة SEO أساسية', 'تحسين تجربة الجوال'],
            ],
            'ecommerce-website' => [
                'title_ar' => 'موقع تجارة إلكترونية',
                'category_ar' => 'متجر إلكتروني',
                'description_ar' => 'متجر إلكتروني احترافي مع كتالوج المنتجات والسلة والدفع وإدارة الطلبات.',
                'features_ar' => ['كتالوج المنتجات والفئات', 'السلة والدفع', 'واجهة دفع جاهزة', 'لوحة الطلبات', 'حساب العميل'],
            ],
            'seo-starter-package' => [
                'title_ar' => 'باقة تحسين محركات البحث',
                'category_ar' => 'خدمات SEO',
                'description_ar' => 'خطة شهرية لتحسين الصحة التقنية والكلمات المفتاحية والصفحات والتقارير.',
                'features_ar' => ['خطة الكلمات المفتاحية', 'تحسين الصفحات', 'فحوص تقنية', 'إرشادات Search Console', 'تقرير شهري'],
            ],
            'laravel-saas-system' => [
                'title_ar' => 'نظام Laravel SaaS',
                'category_ar' => 'تطوير SaaS',
                'description_ar' => 'منصة Laravel SaaS مخصصة مع لوحة مستخدم ولوحة إدارة واشتراكات وسير عمل.',
                'features_ar' => ['بنية Laravel', 'لوحة المستخدم', 'لوحة الإدارة', 'جاهز للاشتراكات', 'تتبع المشاريع'],
            ],
            'mobile-app-development' => [
                'title_ar' => 'تطوير تطبيقات الجوال',
                'category_ar' => 'تطبيقات الجوال',
                'description_ar' => 'تطوير تطبيقات Android وiOS بواجهة حديثة وتكامل API ولوحة إدارة.',
                'features_ar' => ['تطبيق متعدد المنصات', 'واجهة استخدام حديثة', 'تكامل API', 'لوحة إدارة', 'تعديلان'],
            ],
        ];

        foreach ($offerTranslations as $slug => $translation) {
            DB::table('offers')->where('slug', $slug)->update([
                'title_ar' => $translation['title_ar'],
                'category_ar' => $translation['category_ar'],
                'description_ar' => $translation['description_ar'],
                'features_ar' => json_encode($translation['features_ar'], JSON_UNESCAPED_UNICODE),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('services', fn (Blueprint $table) => $table->dropColumn(['service_title_ar', 'service_description_ar']));
        Schema::table('service_details', fn (Blueprint $table) => $table->dropColumn([
            'title_prefix_ar', 'title_highlight_ar', 'description_ar', 'process_heading_ar',
            'process_one_title_ar', 'process_one_text_ar', 'process_two_title_ar', 'process_two_text_ar',
            'process_three_title_ar', 'process_three_text_ar',
        ]));
        Schema::table('blogs', fn (Blueprint $table) => $table->dropColumn(['title_ar', 'category_ar', 'excerpt_ar', 'content_ar', 'author_bio_ar']));
        Schema::table('portfolios', fn (Blueprint $table) => $table->dropColumn(['title_ar', 'category_ar', 'tags_ar', 'duration_ar', 'short_description_ar', 'description_ar']));
        Schema::table('offers', fn (Blueprint $table) => $table->dropColumn([
            'title_ar', 'category_ar', 'description_ar', 'detail_overview_ar', 'hero_visual_title_ar',
            'features_ar', 'overview_items_ar', 'detail_features_ar', 'delivery_timeline_ar', 'faqs_ar', 'why_choose_ar',
        ]));
        Schema::table('industries', fn (Blueprint $table) => $table->dropColumn(['title_ar', 'category_ar', 'description_ar', 'result_ar']));
        Schema::table('reviews', fn (Blueprint $table) => $table->dropColumn(['designation_ar', 'badge_ar', 'review_text_ar']));
        Schema::table('case_studies', fn (Blueprint $table) => $table->dropColumn(['title_ar', 'category_ar', 'summary_ar', 'result_ar']));
        Schema::table('why_nexas', fn (Blueprint $table) => $table->dropColumn(['title_ar', 'description_ar']));
        Schema::table('faqs', fn (Blueprint $table) => $table->dropColumn(['question_ar', 'answer_ar']));
    }
};
