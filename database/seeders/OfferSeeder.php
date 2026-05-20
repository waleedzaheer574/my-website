<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        $offers = [
            [
                'title' => '5 Page Dynamic Website',
                'slug' => '5-page-dynamic-website',
                'category' => 'Website Development',
                'description' => 'A polished dynamic business website with editable content, responsive pages, and conversion-focused sections.',
                'price' => 200,
                'billing_cycle' => 'one_time',
                'delivery_time' => '5-7 Days',
                'features' => [
                    '5 responsive website pages',
                    'Admin editable content',
                    'Contact form integration',
                    'Basic SEO setup',
                    'Mobile-first layout polish',
                ],
                'addons' => [
                    'Extra page',
                    'WhatsApp chat setup',
                    'Speed optimization',
                ],
                'is_popular' => true,
                'sort_order' => 10,
                'detail_overview' => 'This 5 page dynamic website package is ideal for startups and small businesses that need a professional online presence with editable content, fast loading pages, and a clear inquiry journey.',
                'hero_visual_title' => 'Premium business website experience',
                'overview_items' => ['Responsive page structure', 'Admin editable content', 'Lead generation flow', 'SEO friendly setup'],
                'detail_features' => [
                    ['title' => '5 unique pages', 'description' => 'Home, about, services, contact and one custom page.'],
                    ['title' => 'Contact form', 'description' => 'Capture inquiries directly from your website.'],
                    ['title' => 'Admin content controls', 'description' => 'Update important content without developer help.'],
                    ['title' => 'Mobile responsive design', 'description' => 'Clean layout for desktop, tablet and mobile users.'],
                ],
                'tech_stack' => ['Laravel', 'Blade', 'MySQL', 'JavaScript', 'HTML5', 'CSS3'],
                'delivery_timeline' => [
                    ['title' => 'Discovery', 'description' => 'Collect business goals and content requirements.'],
                    ['title' => 'Design', 'description' => 'Prepare the page structure and visual direction.'],
                    ['title' => 'Development', 'description' => 'Build dynamic pages and inquiry flow.'],
                    ['title' => 'Review', 'description' => 'Test content, forms and responsive screens.'],
                    ['title' => 'Launch', 'description' => 'Deploy the completed website.'],
                ],
                'faqs' => [
                    ['question' => 'Can I update the content?', 'answer' => 'Yes. The package includes editable content sections for key website areas.'],
                    ['question' => 'Is the website mobile friendly?', 'answer' => 'Yes. The layout is responsive for desktop, tablet and mobile devices.'],
                    ['question' => 'Do you include SEO?', 'answer' => 'Basic SEO setup is included for pages and metadata.'],
                ],
                'why_choose' => ['Professional modern design', 'Fast delivery', 'Mobile-first layout', 'Basic SEO included', 'Support after launch'],
            ],
            [
                'title' => 'Ecommerce Website',
                'slug' => 'ecommerce-website',
                'category' => 'Online Store',
                'description' => 'A premium ecommerce experience with product catalog, cart flow, checkout UI, and order management foundation.',
                'price' => 1200,
                'billing_cycle' => 'one_time',
                'delivery_time' => '12-18 Days',
                'features' => [
                    'Product catalog and categories',
                    'Cart and checkout journey',
                    'Payment-ready interface',
                    'Order dashboard',
                    'Customer account area',
                ],
                'addons' => [
                    'Payment gateway setup',
                    'Shipping rules',
                    'Inventory alerts',
                ],
                'is_popular' => false,
                'sort_order' => 20,
                'detail_overview' => 'This ecommerce website package is perfect for businesses looking to sell products online with a professional storefront, product management, secure checkout flow and customer-friendly shopping experience.',
                'hero_visual_title' => 'Super fast eCommerce experience',
                'overview_items' => ['Modern & responsive design', 'SEO friendly structure', 'Easy product management', 'Secure checkout system'],
                'detail_features' => [
                    ['title' => 'Product catalog & categories', 'description' => 'Showcase unlimited products with categories.'],
                    ['title' => 'Shopping cart & checkout', 'description' => 'Smooth and secure checkout process.'],
                    ['title' => 'Payment gateway integration', 'description' => 'Connect Stripe, PayPal, bank transfer and more.'],
                    ['title' => 'Order management system', 'description' => 'Track orders, invoices and customer details.'],
                    ['title' => 'Customer account area', 'description' => 'Users can register, login and manage orders.'],
                    ['title' => 'Responsive on all devices', 'description' => 'Fully responsive for all screen sizes.'],
                ],
                'tech_stack' => ['Laravel', 'MySQL', 'Blade', 'Tailwind CSS', 'Stripe', 'JavaScript', 'HTML5', 'CSS3'],
                'delivery_timeline' => [
                    ['title' => 'Discovery', 'description' => 'Understanding store requirements.'],
                    ['title' => 'Design', 'description' => 'Creating ecommerce UI/UX designs.'],
                    ['title' => 'Development', 'description' => 'Building your ecommerce store.'],
                    ['title' => 'Review', 'description' => 'Testing and client review.'],
                    ['title' => 'Launch', 'description' => 'Deploy and launch.'],
                ],
                'faqs' => [
                    ['question' => 'Can I manage products easily?', 'answer' => 'Yes. You can manage products, categories, pricing and stock from the admin panel.'],
                    ['question' => 'Will my website be mobile friendly?', 'answer' => 'Yes. The store is responsive for desktop, tablet and mobile screens.'],
                    ['question' => 'Do you provide domain & hosting?', 'answer' => 'We can guide setup and connect your preferred domain and hosting.'],
                    ['question' => 'Will I get support after delivery?', 'answer' => 'Yes. You can use your dashboard and support chat after delivery.'],
                ],
                'why_choose' => ['Professional & modern designs', 'On-time delivery', 'Lifetime support', 'Money back guarantee', '100% client satisfaction'],
            ],
            [
                'title' => 'SEO Starter Package',
                'slug' => 'seo-starter-package',
                'category' => 'SEO Services',
                'description' => 'A monthly SEO starter plan for technical checks, keyword planning, on-page improvements, and reporting.',
                'price' => 150,
                'billing_cycle' => 'monthly',
                'delivery_time' => 'Monthly',
                'features' => [
                    'Keyword research plan',
                    'On-page SEO fixes',
                    'Technical SEO checks',
                    'Search console guidance',
                    'Monthly performance report',
                ],
                'addons' => [
                    'Blog content brief',
                    'Local SEO setup',
                    'Competitor audit',
                ],
                'is_popular' => false,
                'sort_order' => 30,
                'detail_overview' => 'This SEO starter package helps your website improve technical health, keyword direction, on-page structure and monthly visibility tracking.',
                'hero_visual_title' => 'Search growth and visibility system',
                'overview_items' => ['Technical SEO audit', 'Keyword planning', 'On-page improvements', 'Monthly reporting'],
                'detail_features' => [
                    ['title' => 'Keyword research plan', 'description' => 'Find relevant keywords for your services.'],
                    ['title' => 'Technical SEO checks', 'description' => 'Identify technical issues affecting visibility.'],
                    ['title' => 'On-page optimization', 'description' => 'Improve titles, headings and page structure.'],
                    ['title' => 'Monthly report', 'description' => 'Track improvements and next steps.'],
                ],
                'tech_stack' => ['SEO Audit', 'Search Console', 'Analytics', 'Schema', 'Speed', 'Reports'],
                'delivery_timeline' => [
                    ['title' => 'Audit', 'description' => 'Review current website health.'],
                    ['title' => 'Research', 'description' => 'Prepare keyword and competitor direction.'],
                    ['title' => 'Optimization', 'description' => 'Apply on-page and technical improvements.'],
                    ['title' => 'Report', 'description' => 'Share monthly SEO progress.'],
                ],
                'faqs' => [
                    ['question' => 'Is this monthly?', 'answer' => 'Yes. This package is designed as a monthly SEO starter plan.'],
                    ['question' => 'Do you include reports?', 'answer' => 'Yes. Monthly reporting is included.'],
                ],
                'why_choose' => ['Clear SEO roadmap', 'Technical checks included', 'Monthly reporting', 'Keyword-focused strategy'],
            ],
            [
                'title' => 'Laravel SaaS System',
                'slug' => 'laravel-saas-system',
                'category' => 'SaaS Development',
                'description' => 'A custom Laravel SaaS platform with user dashboard, admin panel, subscriptions, and project workflow.',
                'price' => 3000,
                'billing_cycle' => 'one_time',
                'delivery_time' => '25-40 Days',
                'features' => [
                    'Laravel backend architecture',
                    'User dashboard',
                    'Admin management panel',
                    'Subscription-ready flow',
                    'Project tracking module',
                ],
                'addons' => [
                    'Stripe integration',
                    'Role permissions',
                    'Analytics dashboard',
                ],
                'is_popular' => true,
                'sort_order' => 40,
                'detail_overview' => 'This Laravel SaaS system package is built for businesses that need a scalable platform with users, subscriptions, admin controls, project workflows and a modern dashboard experience.',
                'hero_visual_title' => 'Scalable Laravel SaaS platform',
                'overview_items' => ['Scalable Laravel architecture', 'User dashboard', 'Subscription ready', 'Admin control panel'],
                'detail_features' => [
                    ['title' => 'Laravel backend architecture', 'description' => 'Clean scalable backend foundation.'],
                    ['title' => 'User dashboard', 'description' => 'Client-facing dashboard and account area.'],
                    ['title' => 'Admin panel', 'description' => 'Manage users, orders and content.'],
                    ['title' => 'Subscription-ready flow', 'description' => 'Built around recurring or one-time packages.'],
                    ['title' => 'Project workflow', 'description' => 'Track milestones, messages and delivery.'],
                ],
                'tech_stack' => ['Laravel', 'MySQL', 'Blade', 'Stripe', 'JavaScript', 'HTML5', 'CSS3'],
                'delivery_timeline' => [
                    ['title' => 'Planning', 'description' => 'Define SaaS modules and roles.'],
                    ['title' => 'UX Design', 'description' => 'Design dashboard and core workflows.'],
                    ['title' => 'Development', 'description' => 'Build backend, frontend and admin features.'],
                    ['title' => 'Testing', 'description' => 'Review subscriptions, permissions and flows.'],
                    ['title' => 'Launch', 'description' => 'Deploy the SaaS platform.'],
                ],
                'faqs' => [
                    ['question' => 'Can this include subscriptions?', 'answer' => 'Yes. The system can support monthly, yearly or one-time billing models.'],
                    ['question' => 'Is admin panel included?', 'answer' => 'Yes. Admin management is included in this package.'],
                ],
                'why_choose' => ['Scalable Laravel codebase', 'Dashboard-first workflow', 'Admin management included', 'Subscription-ready build'],
            ],
            [
                'title' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'category' => 'Mobile Apps',
                'description' => 'Android and iOS mobile app development with modern UI, API integrations, and admin control.',
                'price' => 800,
                'billing_cycle' => 'one_time',
                'delivery_time' => '20 Days',
                'features' => [
                    'Cross platform app',
                    'Modern UI/UX',
                    'API integrations',
                    'Admin panel',
                    '2 revisions',
                ],
                'addons' => [
                    'Push notifications',
                    'App store publishing',
                    'Analytics setup',
                ],
                'is_popular' => false,
                'sort_order' => 50,
                'detail_overview' => 'This mobile app development package helps businesses launch a modern cross-platform app with clean UI, API integrations and admin-backed workflows.',
                'hero_visual_title' => 'Modern mobile app experience',
                'overview_items' => ['Cross-platform app', 'Modern UI/UX', 'API integrations', 'Admin connected'],
                'detail_features' => [
                    ['title' => 'Cross platform app', 'description' => 'Android and iOS friendly implementation.'],
                    ['title' => 'Modern UI/UX', 'description' => 'Clean screens for a premium app experience.'],
                    ['title' => 'API integrations', 'description' => 'Connect app screens with your backend.'],
                    ['title' => 'Admin panel', 'description' => 'Manage key app data from admin.'],
                ],
                'tech_stack' => ['Flutter', 'Laravel API', 'MySQL', 'Firebase', 'Stripe', 'Admin Panel'],
                'delivery_timeline' => [
                    ['title' => 'Discovery', 'description' => 'Define app screens and user flows.'],
                    ['title' => 'Design', 'description' => 'Create app UI/UX screens.'],
                    ['title' => 'Development', 'description' => 'Build app and API integrations.'],
                    ['title' => 'Testing', 'description' => 'Test on multiple screen sizes.'],
                    ['title' => 'Delivery', 'description' => 'Prepare final build delivery.'],
                ],
                'faqs' => [
                    ['question' => 'Is this for Android and iOS?', 'answer' => 'Yes. The package is designed for cross-platform mobile app development.'],
                    ['question' => 'Can it connect with my website?', 'answer' => 'Yes. API integrations can connect the app with your existing backend.'],
                ],
                'why_choose' => ['Mobile-first design', 'API integration support', 'Admin-backed workflows', 'Modern app experience'],
            ],
        ];

        foreach ($offers as $offer) {
            Offer::updateOrCreate(
                ['slug' => $offer['slug']],
                array_merge([
                    'currency' => 'AED',
                    'is_active' => true,
                ], $offer)
            );
        }
    }
}
