<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $blogs = [
            'website-optimization-improve-performance-speed-user-experience' => [
                'excerpt_ar' => 'تعرف على كيفية تحسين الموقع لزيادة السرعة ورفع ترتيب SEO وتحسين تجربة المستخدم والتحويلات.',
                'content_ar' => 'لا يساعد الموقع المحسن على الظهور بشكل أفضل في محركات البحث فحسب، بل يقدم أيضاً تجربة سلسة للزوار. يرفع تحسين الموقع سرعة التحميل وتفاعل المستخدم وأداء SEO وكفاءة الموقع بشكل عام.',
            ],
            'seo-optimization-improve-rankings-traffic-online-visibility' => [
                'excerpt_ar' => 'اكتشف كيف يحسن SEO ترتيب البحث ويزيد الزيارات العضوية وظهور موقعك وأداءه عبر الإنترنت.',
                'content_ar' => 'يعد تحسين محركات البحث (SEO) من أكثر الطرق فعالية لزيادة ظهورك الرقمي وجذب زيارات مستهدفة إلى موقعك. تساعد الاستراتيجية القوية أعمالك على الوصول إلى ترتيب أعلى وبناء المصداقية وتوليد مزيد من العملاء المحتملين.',
            ],
            'web-design-create-modern-responsive-user-friendly-websites' => [
                'excerpt_ar' => 'اكتشف كيف يعزز تصميم المواقع الحديث تجربة المستخدم والتجاوب والحضور الرقمي لنمو الأعمال.',
                'content_ar' => 'يلعب تصميم المواقع دوراً أساسياً في إنشاء حضور قوي للأعمال عبر الإنترنت. فالموقع المصمم باحتراف لا يبدو جذاباً فقط، بل يحسن تجربة المستخدم والتفاعل والتحويلات. يركز التصميم الحديث على التخطيطات الواضحة والتجاوب والأداء وسهولة الاستخدام.',
            ],
            'shopify-development-build-powerful-scalable-online-stores' => [
                'excerpt_ar' => 'تعرف على كيفية مساعدة Shopify للأعمال في بناء متاجر قوية بمدفوعات آمنة وميزات تجارة إلكترونية قابلة للتوسع.',
                'content_ar' => 'تعد Shopify من أشهر منصات التجارة الإلكترونية التي تتيح للأعمال إنشاء المتاجر الإلكترونية وإدارتها وتوسيعها دون إعداد تقني معقد. وتوفر حلاً متكاملاً لبيع المنتجات عبر الإنترنت بسهولة ومرونة وأمان.',
            ],
            'top-uiux-design-trends-that-improve-user-experience-in-modern-websites' => [
                'excerpt_ar' => 'اكتشف أحدث اتجاهات تصميم UI/UX التي تساعد المواقع الحديثة على تقديم تجربة أفضل وزيادة التفاعل والتحويلات.',
                'content_ar' => 'في العالم الرقمي اليوم، يلعب تصميم UI/UX دوراً كبيراً في نجاح أي موقع أو تطبيق. تساعد الواجهة الواضحة والتجربة السلسة الأعمال على جذب الزوار وزيادة التفاعل ورفع رضا العملاء. لم يعد التصميم الحديث متعلقاً بالمظهر الجذاب فقط، بل يركز على سهولة الاستخدام وإمكانية الوصول والتجاوب وتقديم تجربة ذات معنى على جميع الأجهزة.',
            ],
            'why-mobile-app-development-is-essential-for-modern-businesses' => [
                'excerpt_ar' => 'اكتشف كيف يساعد تطوير تطبيقات الجوال الأعمال على زيادة تفاعل العملاء والمبيعات وبناء حضور رقمي أقوى.',
                'content_ar' => 'أصبحت تطبيقات الجوال من أقوى الأدوات التي تستخدمها الأعمال للتواصل مع العملاء وتنمية علاماتها التجارية. تستثمر الشركات من مختلف الأحجام في تطوير التطبيقات لتقديم تجارب أسرع وأذكى وأكثر تخصيصاً. لا يحسن التطبيق الاحترافي تفاعل العملاء فحسب، بل يساعد أيضاً على زيادة المبيعات وتبسيط العمليات وتقوية الحضور الرقمي.',
            ],
            'how-meta-digital-marketing-helps-businesses-grow-faster-online' => [
                'excerpt_ar' => 'تعرف على كيفية مساعدة تسويق Meta للأعمال في زيادة الوعي بالعلامة وتوليد العملاء وتحسين التحويلات عبر Facebook وInstagram.',
                'content_ar' => 'تحتاج الأعمال في السوق الرقمي التنافسي إلى استراتيجيات قوية للوصول إلى الجمهور الصحيح وتحقيق نمو حقيقي. أصبح التسويق عبر Meta من أكثر الطرق فعالية للترويج للمنتجات والخدمات. وتقدم منصتا Facebook وInstagram حلولاً إعلانية متقدمة تساعد الشركات على التواصل مع ملايين العملاء المحتملين حول العالم.',
            ],
            'professional-video-editing-services-for-modern-digital-content' => [
                'excerpt_ar' => 'اكتشف كيف يساعد تحرير الفيديو الاحترافي الأعمال وصناع المحتوى والعلامات التجارية على إنتاج محتوى جذاب.',
                'content_ar' => 'أصبح محتوى الفيديو من أقوى وسائل التواصل مع الجمهور عبر الإنترنت. من التسويق على وسائل التواصل إلى محتوى YouTube والعروض التجارية، يلعب التحرير عالي الجودة دوراً رئيسياً في إنشاء تجربة بصرية احترافية وجذابة. يحول تحرير الفيديو المواد الخام إلى محتوى مصقول يلفت الانتباه ويروي قصة ويترك انطباعاً دائماً.',
            ],
            'how-ai-automation-is-transforming-modern-businesses-in-uae-saudi-arabia' => [
                'excerpt_ar' => 'اكتشف كيف تساعد حلول أتمتة الذكاء الاصطناعي الأعمال في الإمارات والسعودية على زيادة الإنتاجية وتقليل التكاليف وتحسين تجربة العملاء.',
                'content_ar' => "يغير الذكاء الاصطناعي بسرعة طريقة عمل الشركات في الإمارات والسعودية. من أتمتة دعم العملاء إلى تحسين الكفاءة التشغيلية، تساعد الأتمتة الشركات على توفير الوقت وتقليل العمل اليدوي وزيادة الإنتاجية.\n\nتستثمر الأعمال حالياً في حلول مثل روبوتات المحادثة وأتمتة واتساب وأنظمة حجز المواعيد وسير العمل الذكي للحفاظ على تنافسيتها.\n\nمزايا أتمتة الذكاء الاصطناعي\n1. دعم عملاء أفضل على مدار الساعة.\n2. إنتاجية أعلى من خلال تقليل المهام المتكررة.\n3. خفض التكاليف التشغيلية.\n4. إدارة أسرع للعملاء المحتملين والمتابعات.\n5. نمو أسرع مع الحفاظ على جودة الخدمة.\n\nالحلول الشائعة\nروبوتات المحادثة، أتمتة واتساب، أنظمة دعم العملاء، حجز المواعيد، سير العمل الذكي وإنشاء المحتوى.",
            ],
            'why-every-growing-business-needs-erp-crm-solutions' => [
                'excerpt_ar' => 'تعرف على كيفية مساعدة أنظمة ERP وCRM للأعمال في أتمتة العمليات وإدارة العملاء وتحسين الإنتاجية.',
                'content_ar' => "تحتاج الأعمال الحديثة إلى أنظمة ذكية لإدارة العملاء والموظفين والمخزون والمبيعات والمالية بكفاءة. أصبحت حلول ERP وCRM أساسية للشركات التي ترغب في تحسين الأداء التشغيلي والعلاقات مع العملاء.\n\nفي الإمارات والسعودية تتبنى الشركات هذه المنصات سريعاً لأتمتة العمليات ودعم النمو طويل الأجل.\n\nأهم المزايا\n1. إدارة مركزية للأقسام من منصة واحدة.\n2. علاقات أفضل مع العملاء ومتابعة التفاعلات.\n3. أتمتة سير العمل والمهام المتكررة.\n4. تقارير وتحليلات فورية لاتخاذ قرارات أفضل.\n5. بنية مرنة وقابلة للتوسع.\n\nالميزات الرئيسية\nإدارة العملاء والموارد البشرية والمخزون والمالية ولوحات التقارير وسير العمل والمبيعات.",
            ],
            'why-cloud-devops-services-are-essential-for-scalable-businesses' => [
                'excerpt_ar' => 'استكشف كيف تحسن خدمات السحابة وDevOps سرعة النشر وقابلية التوسع والأمان وأداء البنية التحتية.',
                'content_ar' => "غيرت الحوسبة السحابية وممارسات DevOps طريقة بناء التطبيقات ونشرها وإدارتها. تحتاج الأعمال الحديثة إلى بنية تحتية آمنة وسريعة وقابلة للتوسع لدعم النمو والحفاظ على الموثوقية.\n\nتساعد حلول السحابة وDevOps الشركات على أتمتة النشر وتحسين أداء الخوادم وتقليل التوقف وتوسيع التطبيقات بكفاءة.\n\nالمزايا\n1. نشر أسرع عبر مسارات CI/CD.\n2. قابلية توسع حسب الطلب والزيارات.\n3. أمان أفضل لحماية البيانات والتطبيقات.\n4. تقليل فترات التوقف بالمراقبة والأتمتة.\n5. تحسين التكاليف.\n\nالخدمات المتضمنة\nإعداد AWS وإدارة VPS ونشر Docker ومسارات CI/CD وتحسين الخادم وإدارة البنية السحابية ومراقبة الأمان.",
            ],
            'how-custom-e-commerce-development-helps-businesses-grow-faster' => [
                'excerpt_ar' => 'اكتشف كيف تساعد حلول التجارة الإلكترونية المخصصة الأعمال على زيادة المبيعات وتحسين تجربة العملاء وبناء متاجر قابلة للتوسع.',
                'content_ar' => "ينمو قطاع التجارة الإلكترونية بسرعة في الإمارات والسعودية، وتتجه الأعمال إلى الإنترنت للوصول إلى عملاء أكثر وزيادة المبيعات وبناء علامات رقمية أقوى.\n\nيتيح تطوير التجارة الإلكترونية المخصص إنشاء متاجر آمنة وقابلة للتوسع وسهلة الاستخدام وفق احتياجات العمل.\n\nالمزايا\n1. زيادة المبيعات والوصول إلى عملاء عالميين.\n2. تجربة أفضل بتصميم متجاوب وتنقل سلس.\n3. دمج مدفوعات آمنة وسهلة.\n4. إدارة المنتجات والطلبات والتسليم بكفاءة.\n5. دعم نمو الأعمال مستقبلاً.\n\nالحلول الشائعة\nتطوير Shopify وWooCommerce والأسواق متعددة البائعين وربط بوابات الدفع وأنظمة إدارة التوصيل والمخزون.",
            ],
        ];

        foreach ($blogs as $slug => $translation) {
            DB::table('blogs')->where('slug', $slug)->update($translation + [
                'author_bio_ar' => 'يشارك فريق Multitechwave رؤى عملية حول الحلول الرقمية والنمو والأداء.',
            ]);
        }

        $portfolios = [
            'a1-rides-smart-taxi-airport-transfer-platform' => [
                'description_ar' => 'A1 Rides هو حل متكامل للنقل وخدمات التوصيل إلى المطار، صمم لتبسيط حجز الرحلات للعملاء وتوفير أدوات فعالة لإدارة الرحلات للسائقين والمسؤولين. ركز المشروع على الأداء وتجربة المستخدم الحديثة والتجاوب وسلاسة تجربة العميل.',
                'duration_ar' => '10/01/2026 - 30/01/2026',
                'tags_ar' => 'حجز سيارات الأجرة، مشاركة الرحلات، التوصيل إلى المطار، Laravel، تطبيق جوال، UI/UX، تصميم المواقع، نظام الحجز',
            ],
            'os-by-aus-fashion-clothing-ecommerce-platform' => [
                'description_ar' => 'OS By AUS منصة أزياء إلكترونية عصرية لعرض مجموعات الملابس المميزة والأزياء الموسمية مع تجربة تسوق سلسة. صمم المشروع بتركيز على واجهة أنيقة ومتجاوبة وتنقل سهل وعرض بصري عالي الجودة لرفع تفاعل العملاء والمبيعات عبر الإنترنت.',
                'duration_ar' => '05/02/2026 - 28/02/2026',
                'tags_ar' => 'متجر أزياء، تجارة إلكترونية، موقع ملابس، UI/UX، Laravel، علامة أزياء، تسوق إلكتروني، تصميم متجاوب',
            ],
            'little-black-limo-luxury-chauffeur-airport-transfer-platform' => [
                'description_ar' => 'Little Black Limo منصة فاخرة لحجز سيارات الليموزين والسائقين، تقدم تجربة رقمية راقية للعملاء الباحثين عن خدمات النقل المميزة. يركز الموقع على التصميم الأنيق والتجاوب والأداء السريع ومسار الحجز السلس عبر جميع الأجهزة.',
                'duration_ar' => '12/04/2026 - 02/05/2026',
                'tags_ar' => 'سائق فاخر، توصيل إلى المطار، خدمة ليموزين، منصة حجز، UI/UX، Laravel، تصميم متجاوب، موقع نقل',
            ],
        ];

        foreach ($portfolios as $slug => $translation) {
            DB::table('portfolios')->where('slug', $slug)->update($translation);
        }

        $caseStudies = [
            'luxury-real-estate-launch' => ['title_ar' => 'إطلاق عقاري فاخر', 'category_ar' => 'العقارات', 'summary_ar' => 'عززنا حضور علامة عقارية فاخرة بنظام حملات مركز رفع حجم العملاء المحتملين المؤهلين.', 'result_ar' => 'زيادة العملاء المؤهلين 42%'],
            'healthcare-lead-funnel' => ['title_ar' => 'مسار عملاء الرعاية الصحية', 'category_ar' => 'الرعاية الصحية', 'summary_ar' => 'أعدنا تصميم مسار الاستحواذ لعلامة عيادة لجعل الثقة والحجز والمتابعة أكثر سهولة.', 'result_ar' => 'زيادة الحجوزات 31%'],
            'e-commerce-retention-push' => ['title_ar' => 'تعزيز الاحتفاظ في التجارة الإلكترونية', 'category_ar' => 'التجارة الإلكترونية', 'summary_ar' => 'جمعنا الإعلانات المدفوعة والبريد الدوري وتحسين صفحات الهبوط لزيادة المشتريات المتكررة.', 'result_ar' => 'زيادة المبيعات المتكررة 27%'],
            'saas-trial-activation' => ['title_ar' => 'تفعيل تجربة SaaS', 'category_ar' => 'التقنية', 'summary_ar' => 'حسنا قصة المنتج ومسار التسجيل حتى يصل مستخدمو التجربة إلى التفعيل بشكل أسرع.', 'result_ar' => 'زيادة التفعيل التجريبي 36%'],
            'education-enrollment-campaign' => ['title_ar' => 'حملة التسجيل التعليمي', 'category_ar' => 'التعليم', 'summary_ar' => 'بنينا صفحات هبوط ومحتوى إعادة استهداف مخصصين لموسم القبول.', 'result_ar' => 'زيادة الطلبات 48%'],
            'hospitality-booking-funnel' => ['title_ar' => 'مسار حجوزات الضيافة', 'category_ar' => 'الضيافة', 'summary_ar' => 'أنشأنا تجربة حجز تركز على الجوال وحملة بحث محلية لمكان مميز.', 'result_ar' => 'زيادة الحجوزات المباشرة 29%'],
            'legal-services-local-seo' => ['title_ar' => 'SEO محلي للخدمات القانونية', 'category_ar' => 'القانون', 'summary_ar' => 'عززنا الظهور المحلي ووضوح صفحات الخدمات لمكتب استشاري متنام.', 'result_ar' => 'زيادة الاستفسارات العضوية 34%'],
            'fitness-membership-growth' => ['title_ar' => 'نمو عضويات اللياقة', 'category_ar' => 'اللياقة', 'summary_ar' => 'أطلقنا نظام حملات للعضويات وتجارب الحصص والمتابعة الآلية.', 'result_ar' => 'زيادة عملاء العضوية 40%'],
        ];

        foreach ($caseStudies as $slug => $translation) {
            DB::table('case_studies')->where('slug', $slug)->update($translation);
        }
    }

    public function down(): void
    {
        DB::table('blogs')->whereIn('slug', [
            'website-optimization-improve-performance-speed-user-experience',
            'seo-optimization-improve-rankings-traffic-online-visibility',
            'web-design-create-modern-responsive-user-friendly-websites',
            'shopify-development-build-powerful-scalable-online-stores',
            'top-uiux-design-trends-that-improve-user-experience-in-modern-websites',
            'why-mobile-app-development-is-essential-for-modern-businesses',
            'how-meta-digital-marketing-helps-businesses-grow-faster-online',
            'professional-video-editing-services-for-modern-digital-content',
            'how-ai-automation-is-transforming-modern-businesses-in-uae-saudi-arabia',
            'why-every-growing-business-needs-erp-crm-solutions',
            'why-cloud-devops-services-are-essential-for-scalable-businesses',
            'how-custom-e-commerce-development-helps-businesses-grow-faster',
        ])->update(['excerpt_ar' => null, 'content_ar' => null, 'author_bio_ar' => null]);

        DB::table('portfolios')->whereIn('slug', [
            'a1-rides-smart-taxi-airport-transfer-platform',
            'os-by-aus-fashion-clothing-ecommerce-platform',
            'little-black-limo-luxury-chauffeur-airport-transfer-platform',
        ])->update(['description_ar' => null, 'duration_ar' => null, 'tags_ar' => null]);

        DB::table('case_studies')->whereIn('slug', array_keys([
            'luxury-real-estate-launch' => true,
            'healthcare-lead-funnel' => true,
            'e-commerce-retention-push' => true,
            'saas-trial-activation' => true,
            'education-enrollment-campaign' => true,
            'hospitality-booking-funnel' => true,
            'legal-services-local-seo' => true,
            'fitness-membership-growth' => true,
        ]))->update(['title_ar' => null, 'category_ar' => null, 'summary_ar' => null, 'result_ar' => null]);
    }
};
