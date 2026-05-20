<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\CompanySetting;
use App\Models\Logo;
use App\Models\MailSetting;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServiceRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedCompanySettings();
        $this->seedMailSettings();
        $services = $this->seedServices();
        $this->seedServiceDetails($services);
        $this->seedBlogs();
        $this->seedLogos();
        $this->seedServiceRequests($services);
    }

    protected function seedCompanySettings(): void
    {
        CompanySetting::create([
            'logo' => 'website/assets/img/design-agency/logo.png',
            'phone' => '+1 (214) 555-0187',
            'whatsapp_number' => '+1 (214) 555-0187',
            'quote_link' => '/contact',
            'fax' => '+1 (214) 555-0199',
            'address' => '1480 Market Street, Suite 400, San Francisco, CA 94102',
            'email' => 'hello@multitechwave.com',
            'smtp_email' => 'admin@gmail.com',
            'smtp_password' => 'asdf007@',
            'notification_email' => 'admin@gmail.com',
            'instagram' => 'https://instagram.com/multitechwave',
            'pinterest' => 'https://pinterest.com/multitechwave',
            'facebook' => 'https://facebook.com/multitechwave',
            'youtube' => 'https://youtube.com/@multitechwave',
            'tiktok' => 'https://tiktok.com/@multitechwave',
            'linkedin' => 'https://linkedin.com/company/multitechwave',
        ]);
    }

    protected function seedMailSettings(): void
    {
        MailSetting::create([
            'sender_email' => 'admin@gmail.com',
            'sender_password' => 'asdf007@',
            'notification_email' => 'admin@gmail.com',
        ]);
    }

    protected function seedServices()
    {
        $serviceSeeds = [
            [
                'service_title' => 'SEO Growth Strategy',
                'service_description' => 'Technical SEO, content structure, and ranking improvements designed to grow qualified traffic.',
                'icon' => $this->copyPublicAsset(
                    'website/assets/img/design-agency/cover.png',
                    'uploads/services',
                    'seo-growth-strategy.png'
                ),
                'created_at' => now()->subMonths(5),
                'updated_at' => now()->subMonths(5),
            ],
            [
                'service_title' => 'Social Media Marketing',
                'service_description' => 'Campaign planning, creative execution, and channel management for steady brand visibility.',
                'icon' => $this->copyPublicAsset(
                    'website/assets/img/design-agency/cta-img.png',
                    'uploads/services',
                    'social-media-marketing.png'
                ),
                'created_at' => now()->subMonths(4),
                'updated_at' => now()->subMonths(4),
            ],
            [
                'service_title' => 'Performance Advertising',
                'service_description' => 'Conversion-focused paid campaigns across search and social with transparent reporting.',
                'icon' => $this->copyPublicAsset(
                    'website/assets/img/design-agency/hero-img.png',
                    'uploads/services',
                    'performance-advertising.png'
                ),
                'created_at' => now()->subMonths(3),
                'updated_at' => now()->subMonths(3),
            ],
            [
                'service_title' => 'Brand Identity Design',
                'service_description' => 'Visual systems, messaging direction, and brand assets for a stronger market presence.',
                'icon' => $this->copyPublicAsset(
                    'website/assets/img/design-agency/Slider-image.png',
                    'uploads/services',
                    'brand-identity-design.png'
                ),
                'created_at' => now()->subMonths(2),
                'updated_at' => now()->subMonths(2),
            ],
            [
                'service_title' => 'Website Optimization',
                'service_description' => 'Landing page, UX, and speed improvements that help visitors turn into customers.',
                'icon' => $this->copyPublicAsset(
                    'website/assets/img/design-agency/launching-project.svg',
                    'uploads/services',
                    'website-optimization.svg'
                ),
                'created_at' => now()->subMonth(),
                'updated_at' => now()->subMonth(),
            ],
        ];

        return collect($serviceSeeds)->map(fn (array $service) => Service::create($service));
    }

    protected function seedServiceDetails($services): void
    {
        foreach ($services->values() as $index => $service) {
            $number = $index + 1;

            ServiceDetail::create([
                'service_id' => $service->id,
                'slug' => Str::slug($service->service_title),
                'title_prefix' => 'Scale with',
                'title_highlight' => $service->service_title,
                'description' => "Our {$service->service_title} offering helps growing companies streamline execution, sharpen positioning, and improve campaign performance with a practical roadmap.",
                'process_heading' => 'How we deliver results',
                'process_one_title' => 'Audit & Research',
                'process_one_text' => 'We review your current assets, competitors, and customer journey to find the biggest growth opportunities.',
                'process_two_title' => 'Execution Plan',
                'process_two_text' => 'A clear roadmap is built around priority fixes, campaign structure, content direction, and reporting expectations.',
                'process_three_title' => 'Optimization Loop',
                'process_three_text' => 'We measure outcomes weekly and iterate fast so the strategy keeps improving instead of going stale.',
                'primary_image' => $this->copyPublicAsset(
                    'website/assets/img/design-agency/home-portfolio-1.jpeg',
                    'uploads/service-details',
                    "service-detail-{$number}.jpeg"
                ),
                'video_thumbnail' => $this->copyPublicAsset(
                    'website/assets/img/design-agency/home-portfolio-2.jpeg',
                    'uploads/service-details',
                    "service-video-thumb-{$number}.jpeg"
                ),
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'created_at' => now()->subMonths(max(1, 5 - $index)),
                'updated_at' => now()->subMonths(max(1, 5 - $index)),
            ]);
        }
    }

    protected function seedBlogs(): void
    {
        $blogs = [
            [
                'title' => 'How Small Businesses Can Build a Consistent Content Engine',
                'slug' => 'how-small-businesses-can-build-a-consistent-content-engine',
                'author_name' => 'Awais Zaheer',
                'category' => 'Content Marketing',
                'excerpt' => 'A practical workflow for publishing content consistently without building a huge team.',
                'content' => '<p>Consistency beats intensity in content marketing. Start with a simple editorial rhythm, align every post to one customer problem, and publish in reusable formats.</p><p>When teams create around proven questions, distribution becomes easier and the same topic can support blog posts, social clips, email copy, and landing page updates.</p>',
                'author_bio' => 'Awais works with growing businesses on content systems, SEO structure, and demand generation.',
                'views' => 126,
                'published_at' => now()->subMonths(3),
                'created_at' => now()->subMonths(3),
                'updated_at' => now()->subMonths(3),
            ],
            [
                'title' => 'The Landing Page Tweaks That Usually Improve Conversion First',
                'slug' => 'the-landing-page-tweaks-that-usually-improve-conversion-first',
                'author_name' => 'Maham Shah',
                'category' => 'CRO',
                'excerpt' => 'Start with clarity, proof, and a stronger CTA before redesigning everything.',
                'content' => '<p>Most low-converting pages do not need a full rebuild. They need clearer hierarchy, sharper proof, tighter copy, and fewer distractions above the fold.</p><p>Teams that fix headline-message match, social proof placement, and form friction often see meaningful conversion gains quickly.</p>',
                'author_bio' => 'Maham focuses on conversion research, UX writing, and landing page strategy.',
                'views' => 184,
                'published_at' => now()->subMonths(2),
                'created_at' => now()->subMonths(2),
                'updated_at' => now()->subMonths(2),
            ],
            [
                'title' => 'What to Track in Paid Campaigns Beyond CTR',
                'slug' => 'what-to-track-in-paid-campaigns-beyond-ctr',
                'author_name' => 'Hamza Ali',
                'category' => 'Paid Media',
                'excerpt' => 'CTR matters, but cost per qualified lead and funnel quality matter more.',
                'content' => '<p>Clicks alone can hide poor traffic quality. Stronger campaign analysis looks at cost per qualified lead, downstream conversion rate, and message fit across the funnel.</p><p>When reporting is tied to real business outcomes, budget decisions become much easier to defend.</p>',
                'author_bio' => 'Hamza manages paid search and social campaigns for service-led brands.',
                'views' => 97,
                'published_at' => now()->subMonth(),
                'created_at' => now()->subMonth(),
                'updated_at' => now()->subMonth(),
            ],
        ];

        foreach ($blogs as $index => $blog) {
            $number = $index + 1;

            Blog::create(array_merge($blog, [
                'featured_image' => $this->copyPublicAsset(
                    'website/assets/img/design-agency/blog-bg.jpg',
                    'uploads/blogs',
                    "blog-featured-{$number}.jpg"
                ),
                'author_image' => $this->copyPublicAsset(
                    'website/assets/img/design-agency/avater2.jpg',
                    'uploads/blogs',
                    "blog-author-{$number}.jpg"
                ),
                'is_active' => true,
            ]));
        }
    }

    protected function seedLogos(): void
    {
        $logos = [
            'website/assets/img/design-agency/carasoul-logo-1.png',
            'website/assets/img/design-agency/carasoul-logo-2.png',
            'website/assets/img/design-agency/carasoul-logo-3.png',
            'website/assets/img/design-agency/carasoul-logo-4.png',
        ];

        foreach ($logos as $index => $logoPath) {
            Logo::create([
                'logo' => $this->copyPublicAssetToStorage(
                    $logoPath,
                    'logos',
                    'partner-logo-'.($index + 1).'.'.pathinfo($logoPath, PATHINFO_EXTENSION)
                ),
            ]);
        }
    }

    protected function seedServiceRequests($services): void
    {
        $requests = [
            ['name' => 'Ahmed Raza', 'company' => 'NovaEdge', 'country' => 'Pakistan'],
            ['name' => 'Sarah Khan', 'company' => 'BluePeak Studio', 'country' => 'United Arab Emirates'],
            ['name' => 'Usman Tariq', 'company' => 'RankOrbit', 'country' => 'United States'],
        ];

        foreach ($requests as $index => $request) {
            $service = $services[$index % $services->count()];

            ServiceRequest::create([
                'full_name' => $request['name'],
                'company_name' => $request['company'],
                'company_website' => 'https://example'.($index + 1).'.com',
                'company_email' => 'lead'.($index + 1).'@example.com',
                'phone_no' => '+92-300-000000'.$index,
                'country' => $request['country'],
                'service_type' => $service->service_title,
                'created_at' => now()->subDays(10 - ($index * 2)),
                'updated_at' => now()->subDays(10 - ($index * 2)),
            ]);
        }
    }

    protected function copyPublicAsset(string $sourceRelativePath, string $destinationRelativeDir, string $fileName): string
    {
        $sourcePath = public_path($sourceRelativePath);
        $destinationDir = public_path($destinationRelativeDir);

        if (! File::exists($destinationDir)) {
            File::makeDirectory($destinationDir, 0755, true);
        }

        $destinationPath = $destinationDir.DIRECTORY_SEPARATOR.$fileName;
        File::copy($sourcePath, $destinationPath);

        return trim(str_replace('\\', '/', $destinationRelativeDir.'/'.$fileName), '/');
    }

    protected function copyPublicAssetToStorage(string $sourceRelativePath, string $destinationDir, string $fileName): string
    {
        $sourcePath = public_path($sourceRelativePath);
        $storagePath = trim($destinationDir.'/'.$fileName, '/');

        Storage::disk('public')->put($storagePath, File::get($sourcePath));

        return $storagePath;
    }
}
