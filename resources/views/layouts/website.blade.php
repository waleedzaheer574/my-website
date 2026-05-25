<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  @php
    $websiteBaseTitle = 'Multitechwave';
    $websiteTitle = trim($__env->yieldContent('title'));

    if ($websiteTitle === '') {
        if (!empty($blog?->title)) {
            $websiteTitle = $blog->title;
        } elseif (!empty($portfolio?->title)) {
            $websiteTitle = $portfolio->title;
        } elseif (!empty($serviceDetail)) {
            $websiteTitle = trim(($serviceDetail->title_prefix ?? '') . ' ' . ($serviceDetail->title_highlight ?? ''));
        } else {
            $path = request()->path();

            $titleMap = [
                '' => 'Home',
                '/' => 'Home',
                'about' => 'About Us',
                'service' => 'Services',
                'service-details' => 'Service Details',
                'portfolio' => 'Portfolio',
                'portfolio-details' => 'Portfolio Details',
                'industries' => 'Industries',
                'case-studies' => 'Case Studies',
                'testimonials' => 'Testimonials',
                'blog' => 'Blog',
                'blog-details' => 'Blog Details',
                'contact' => 'Contact Us',
                'privacy-policy' => 'Privacy Policy',
                'sitemap' => 'Sitemap',
                'careers' => 'Careers',
                'terms' => 'Terms',
                'login' => 'Login',
            ];

            if ($path === '/' || $path === '') {
                $websiteTitle = 'Home';
            } else {
                $websiteTitle = $titleMap['/' . ltrim($path, '/')] ?? $titleMap[$path] ?? str($path)->replace('-', ' ')->title()->value();
            }
        }
    }

    $websiteTitle = $websiteTitle !== '' ? $websiteTitle . ' | ' . $websiteBaseTitle : $websiteBaseTitle;

    $path = request()->path();
    $pageKey = $path === '/' || $path === '' ? '' : trim($path, '/');
    $companySettingForSeo = $websiteCompanySetting ?? null;
    $seoCompanyName = $websiteCompanyName ?? 'Multitechwave';
    $seoSiteUrl = url('/');
    $seoCanonical = url()->current();
    $seoLogo = asset('website/assets/img/design-agency/logo.svg');
    $seoDefaultImage = asset('website/assets/img/generated/home-hero-optimized.jpg');

    $descriptionMap = [
        '' => 'Multitechwave helps businesses grow with website design, development, SEO, branding, digital marketing, and conversion-focused online experiences.',
        'about' => 'Learn about Multitechwave, a digital agency focused on web design, development, SEO, branding, and growth strategies for modern businesses.',
        'service' => 'Explore Multitechwave services including web design, website optimization, brand identity, SEO, digital marketing, and business growth solutions.',
        'portfolio' => 'View Multitechwave portfolio of websites, brand systems, digital campaigns, and creative projects built for growing businesses.',
        'industries' => 'Discover how Multitechwave supports different industries with tailored digital strategy, web design, branding, and marketing services.',
        'case-studies' => 'Read Multitechwave case studies and see how strategy, design, development, and marketing improve digital performance.',
        'testimonials' => 'See client testimonials and reviews for Multitechwave digital design, development, SEO, and marketing services.',
        'blog' => 'Read Multitechwave blog for insights on website design, SEO, branding, digital marketing, and online business growth.',
        'contact' => 'Contact Multitechwave to discuss your website, branding, SEO, digital marketing, or business growth project.',
        'privacy-policy' => 'Read the Multitechwave privacy policy to learn how website inquiries, service requests, and contact information are handled.',
        'sitemap' => 'Browse the Multitechwave sitemap for quick access to services, portfolio, blog, contact, and company pages.',
        'careers' => 'Explore career opportunities with Multitechwave across web design, Shopify, development, SEO, branding, and digital marketing.',
        'terms' => 'Review Multitechwave website terms for service requests, project quotes, timelines, and responsible website use.',
    ];

    $keywordsMap = [
        '' => 'web design agency, digital marketing agency, SEO services, website development, brand identity design',
        'about' => 'about Multitechwave, digital agency, web design team, SEO agency',
        'service' => 'web design services, SEO services, website optimization, branding services, digital marketing',
        'portfolio' => 'web design portfolio, branding portfolio, digital agency work',
        'industries' => 'industry web design, business digital marketing, industry SEO services',
        'case-studies' => 'digital marketing case studies, web design case studies, SEO case studies',
        'testimonials' => 'client reviews, digital agency testimonials, web design reviews',
        'blog' => 'SEO blog, web design tips, digital marketing blog, branding insights',
        'contact' => 'contact web design agency, request website quote, digital marketing consultation',
        'privacy-policy' => 'Multitechwave privacy policy, data protection, website privacy',
        'sitemap' => 'Multitechwave sitemap, website links, company pages',
        'careers' => 'Multitechwave careers, web design jobs, SEO jobs, digital marketing jobs',
        'terms' => 'Multitechwave terms, website terms, service request terms',
    ];

    $seoDescription = trim($__env->yieldContent('description'));
    $seoKeywords = trim($__env->yieldContent('keywords'));
    $seoImage = $seoDefaultImage;
    $seoType = 'website';

    if ($seoDescription === '') {
        if (!empty($blog)) {
            $seoDescription = $blog->excerpt ?: \Illuminate\Support\Str::limit(strip_tags((string) $blog->content), 160);
            $seoImage = $blog->featured_image ? asset($blog->featured_image) : $seoDefaultImage;
            $seoType = 'article';
            $seoKeywords = $seoKeywords ?: trim(implode(', ', array_filter([$blog->category, 'Multitechwave blog', 'digital marketing', 'web design', 'SEO'])));
        } elseif (!empty($serviceDetail)) {
            $serviceTitle = trim(($serviceDetail->title_prefix ?? '') . ' ' . ($serviceDetail->title_highlight ?? ''));
            $seoDescription = $serviceDetail->description ?: 'Learn more about '.$serviceTitle.' services from Multitechwave.';
            $seoImage = $serviceDetail->primary_image ? asset($serviceDetail->primary_image) : $seoDefaultImage;
            $seoKeywords = $seoKeywords ?: trim($serviceTitle.', web design, SEO, digital marketing, Multitechwave');
        } elseif (!empty($portfolio)) {
            $seoDescription = $portfolio->short_description ?: \Illuminate\Support\Str::limit(strip_tags((string) $portfolio->description), 160);
            $seoImage = $portfolio->image ? asset($portfolio->image) : $seoDefaultImage;
            $seoType = 'article';
            $seoKeywords = $seoKeywords ?: trim(implode(', ', array_filter([$portfolio->category, $portfolio->tags, 'portfolio', 'Multitechwave'])));
        } elseif (!empty($offer)) {
            $seoDescription = $offer->description ?: 'Explore '.$offer->title.' services and pricing from Multitechwave.';
            $seoKeywords = $seoKeywords ?: trim(implode(', ', array_filter([$offer->category, $offer->title, 'digital services', 'Multitechwave'])));
        } else {
            $seoDescription = $descriptionMap[$pageKey] ?? 'Multitechwave provides web design, development, SEO, branding, and digital marketing services for growing businesses.';
            $seoKeywords = $seoKeywords ?: ($keywordsMap[$pageKey] ?? 'Multitechwave, web design, SEO, digital marketing, branding');
        }
    }

    $seoDescription = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($seoDescription))), 160, '');
    $seoShouldNoIndex = request()->routeIs(
        'login',
        'register',
        'password.*',
        'user.*',
        'website.quote-generator*',
        'website.checkout'
    ) || request()->is('dashboard*', 'requests*', 'profile');
    $seoRobots = $seoShouldNoIndex ? 'noindex, nofollow, noarchive' : 'index, follow, max-image-preview:large';
    $themeSetting = $websiteCompanySetting ?? null;
    $validThemeColor = fn ($color, $fallback) => preg_match('/^#[0-9A-Fa-f]{6}$/', (string) $color) ? $color : $fallback;
    $themePrimary = $validThemeColor($themeSetting?->theme_primary_color, '#38BDF8');
    $themeSecondary = $validThemeColor($themeSetting?->theme_secondary_color, '#22C55E');
    $themeDark = $validThemeColor($themeSetting?->theme_dark_color, '#020617');
    $schemaGraph = [
        [
            '@type' => 'Organization',
            '@id' => $seoSiteUrl.'/#organization',
            'name' => $seoCompanyName,
            'url' => $seoSiteUrl,
            'logo' => $seoLogo,
            'email' => $companySettingForSeo?->email,
            'telephone' => $companySettingForSeo?->phone,
            'sameAs' => array_values(array_filter([
                $companySettingForSeo?->facebook,
                $companySettingForSeo?->instagram,
                $companySettingForSeo?->linkedin,
                $companySettingForSeo?->youtube,
                $companySettingForSeo?->tiktok,
                $companySettingForSeo?->pinterest,
            ])),
        ],
        [
            '@type' => 'WebSite',
            '@id' => $seoSiteUrl.'/#website',
            'url' => $seoSiteUrl,
            'name' => $seoCompanyName,
            'publisher' => ['@id' => $seoSiteUrl.'/#organization'],
        ],
        [
            '@type' => 'WebPage',
            '@id' => $seoCanonical.'/#webpage',
            'url' => $seoCanonical,
            'name' => $websiteTitle,
            'description' => $seoDescription,
            'isPartOf' => ['@id' => $seoSiteUrl.'/#website'],
            'about' => ['@id' => $seoSiteUrl.'/#organization'],
            'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => $seoImage],
        ],
    ];

    if ($pageKey !== '') {
        $schemaGraph[] = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => $seoSiteUrl,
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => str($websiteTitle)->before(' | ')->value(),
                    'item' => $seoCanonical,
                ],
            ],
        ];
    }

    if (!empty($blog)) {
        $schemaGraph[] = [
            '@type' => 'BlogPosting',
            'headline' => $blog->title,
            'description' => $seoDescription,
            'image' => $seoImage,
            'datePublished' => optional($blog->published_at)->toIso8601String(),
            'dateModified' => optional($blog->updated_at)->toIso8601String(),
            'author' => ['@type' => 'Person', 'name' => $blog->author_name ?: $seoCompanyName],
            'publisher' => ['@id' => $seoSiteUrl.'/#organization'],
            'mainEntityOfPage' => ['@id' => $seoCanonical.'/#webpage'],
        ];
    } elseif (!empty($serviceDetail)) {
        $schemaGraph[] = [
            '@type' => 'Service',
            'name' => trim(($serviceDetail->title_prefix ?? '') . ' ' . ($serviceDetail->title_highlight ?? '')),
            'description' => $seoDescription,
            'provider' => ['@id' => $seoSiteUrl.'/#organization'],
            'url' => $seoCanonical,
        ];
    } elseif (!empty($portfolio)) {
        $schemaGraph[] = [
            '@type' => 'CreativeWork',
            'name' => $portfolio->title,
            'description' => $seoDescription,
            'image' => $seoImage,
            'creator' => ['@id' => $seoSiteUrl.'/#organization'],
            'url' => $seoCanonical,
        ];
    } elseif (!empty($offer)) {
        $schemaGraph[] = [
            '@type' => 'Service',
            'name' => $offer->title,
            'description' => $seoDescription,
            'category' => $offer->category ?: 'Digital services',
            'provider' => ['@id' => $seoSiteUrl.'/#organization'],
            'offers' => [
                '@type' => 'Offer',
                'url' => $seoCanonical,
                'priceCurrency' => $offer->currency,
                'price' => $offer->price,
                'availability' => 'https://schema.org/InStock',
            ],
            'url' => $seoCanonical,
        ];
    }

    $schemaData = [
        '@context' => 'https://schema.org',
        '@graph' => $schemaGraph,
    ];
  @endphp
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="{{ $seoDescription }}">
  <meta name="keywords" content="{{ $seoKeywords }}">
  <meta name="author" content="{{ $seoCompanyName }}">
  <meta name="robots" content="{{ $seoRobots }}">
  <meta name="theme-color" content="{{ $themePrimary ?? '#38BDF8' }}">
  <meta name="format-detection" content="telephone=no">
  <meta name="google-site-verification" content="fvX3GqVuvdVQjJJTjv1jECh1ZTFWbKMlBU1uIwe2Wl0">
  <link rel="canonical" href="{{ $seoCanonical }}">
  <link rel="alternate" hreflang="en" href="{{ $seoCanonical }}">
  <link rel="alternate" hreflang="x-default" href="{{ $seoCanonical }}">
  <meta property="og:site_name" content="{{ $seoCompanyName }}">
  <meta property="og:type" content="{{ $seoType }}">
  <meta property="og:title" content="{{ $websiteTitle }}">
  <meta property="og:description" content="{{ $seoDescription }}">
  <meta property="og:url" content="{{ $seoCanonical }}">
  <meta property="og:image" content="{{ $seoImage }}">
  <meta property="og:image:alt" content="{{ str($websiteTitle)->before(' | ')->value() }}">
  @if(!empty($blog))
    <meta property="article:published_time" content="{{ optional($blog->published_at ?: $blog->created_at)->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ optional($blog->updated_at)->toIso8601String() }}">
    @if($blog->category)
      <meta property="article:section" content="{{ $blog->category }}">
    @endif
  @endif
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $websiteTitle }}">
  <meta name="twitter:description" content="{{ $seoDescription }}">
  <meta name="twitter:image" content="{{ $seoImage }}">
  <script type="application/ld+json">{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
  <link rel="icon" type="image/svg+xml" sizes="any" href="{{ asset('favicon.svg') }}?v=20260513c">
  <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('favicon.png') }}?v=20260513c">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=20260513c">
  <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v=20260513c">
  <link rel="preload" href="{{ asset('website/assets/fonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="{{ asset('website/assets/fonts/fa-brands-400.woff2') }}" as="font" type="font/woff2" crossorigin>
  <!-- Site Title -->
  <title>{{ $websiteTitle }}</title>
  <link rel="stylesheet" href="{{ asset('website/assets/css/plugins/fontawesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('website/assets/css/plugins/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('website/assets/css/plugins/lightgallery.min.css') }}" media="print" onload="this.media='all'">
  <link rel="stylesheet" href="{{ asset('website/assets/css/plugins/slick.css') }}" media="print" onload="this.media='all'">
  <link rel="stylesheet" href="{{ asset('website/assets/css/plugins/animate.css') }}" media="print" onload="this.media='all'">
  <noscript>
    <link rel="stylesheet" href="{{ asset('website/assets/css/plugins/lightgallery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/plugins/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/plugins/animate.css') }}">
  </noscript>
  <link rel="stylesheet" href="{{ asset('website/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('website/assets/css/theme_7.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" media="print" onload="this.media='all'">
  <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"></noscript>
  <link rel="stylesheet" href="{{ asset('website/assets/css/tcw-custom.css') }}">
  @php
  @endphp
  <style>
    :root {
      --cs-accent: {{ $themePrimary }};
      --cs-accent-2: {{ $themeSecondary }};
      --tcw-theme-dark: {{ $themeDark }};
      --tcw-theme-primary-soft: color-mix(in srgb, var(--cs-accent) 14%, transparent);
      --tcw-theme-secondary-soft: color-mix(in srgb, var(--cs-accent-2) 18%, transparent);
    }

    .cs-accent_color,
    a:hover,
    .cs-accent_color_hover:hover,
    .cs-accent_10_color_hover:hover,
    .cs-accent_20_color_hover:hover,
    .cs-accent_30_color_hover:hover,
    .cs-accent_40_color_hover:hover,
    .cs-accent_50_color_hover:hover,
    .cs-accent_60_color_hover:hover,
    .cs-accent_70_color_hover:hover,
    .cs-accent_80_color_hover:hover,
    .cs-accent_90_color_hover:hover,
    .cs-accordians.cs-style2 .cs-accordian_head:hover .cs-accordian_title,
    .cs-nav .cs-nav_list ul a:hover,
    .cs-tab_links.cs-style1 li:not(.active) a:hover,
    .cs-icon_box.cs-style7:hover .cs-icon_box_title,
    .cs-post_pagination.cs-style1 .page-numbers .page-number:hover,
    .cs-post_pagination.cs-style2 .page-numbers a.page-number:hover,
    .cs-post_pagination.cs-style2 .page-numbers .page-number.current,
    .tcw-icon-fallback-accent,
    .tcw-nav_item.is-active > a,
    .tcw-nav_item.is-active > .tcw-dropdown_link_group > a,
    .tcw-nav_item:hover > a,
    .tcw-nav_item:hover > .tcw-dropdown_link_group,
    .tcw-dropdown_toggle:hover,
    .tcw-mobile_link.is-active,
    .tcw-service_arrow,
    .tcw-service_item:hover .tcw-service_title,
    .tcw-floating-panel a,
    .tcw-contact-link,
    .tcw-header_icon:hover,
    .tcw-header_cta_secondary:hover,
    .service-card button:hover,
    .view-all:hover,
    .tcw-footer .menu a:hover,
    .tcw-footer .cs-social_btns a:hover {
      color: var(--cs-accent) !important;
    }

    .cs-accent_color_2,
    .cs-accent_color_2_hover:hover,
    .cs-accent_10_color_2_hover:hover,
    .cs-accent_20_color_2_hover:hover,
    .cs-accent_30_color_2_hover:hover,
    .cs-accent_40_color_2_hover:hover,
    .cs-accent_50_color_2_hover:hover,
    .cs-accent_60_color_2_hover:hover,
    .cs-accent_70_color_2_hover:hover,
    .cs-accent_80_color_2_hover:hover,
    .cs-accent_90_color_2_hover:hover,
    .cs-icon_box.cs-style2:hover .cs-add_btn,
    .cs-site_header.cs-style3 .cs-nav .cs-nav_list > li > a:hover,
    .cs-site_header.cs-style3 .cs-nav .cs-nav_list ul a:hover,
    .cs-counter.cs-style5:hover .cs-counter_number {
      color: var(--cs-accent-2) !important;
    }

    .cs-accent_bg,
    .cs-accent_bg_hover:hover,
    .cs-accent_60_bg_hover:hover,
    .cs-accent_70_bg_hover:hover,
    .cs-accent_80_bg_hover:hover,
    .cs-accent_90_bg_hover:hover,
    .cs-pricing_table.cs-style2:hover .cs-pricing_btn,
    .cs-icon_box.cs-style7:hover .cs-icon_box_icon,
    .cs-post_pagination.cs-style1 .page-numbers .page-number:hover,
    .cs-post_pagination.cs-style2 .page-numbers a.next:hover,
    .select2-container--default .select2-results__option[aria-selected=true],
    .select2-container--default .select2-results__option--highlighted[aria-selected],
    .tcw-header_cta,
    .tcw-floating-contact__icon:hover,
    .tcw-floating-contact__quote,
    .tcw-floating-contact__quote:hover,
    .tcw-floating-whatsapp,
    .tcw-floating-whatsapp:hover,
    .tcw-review-arrow:hover,
    .tcw-blog-rail_arrow:hover,
    .tcw-mobile_group_toggle[aria-expanded="true"],
    .tcw-floating-toggle,
    .tcw-floating-submit,
    .tcw-newsletter-message i {
      background-color: var(--cs-accent) !important;
      border-color: var(--cs-accent) !important;
    }

    .cs-accent_bg_2,
    .cs-accent_bg_2_hover:hover,
    .cs-accent_60_bg_2_hover:hover,
    .cs-accent_70_bg_2_hover:hover,
    .cs-accent_80_bg_2_hover:hover,
    .cs-accent_90_bg_2_hover:hover,
    .cs-tab_links.cs-style3 a:hover,
    .tagcloud a:hover {
      background-color: var(--cs-accent-2) !important;
      border-color: var(--cs-accent-2) !important;
    }

    .cs-accent_border,
    .cs-accent_border_hover:hover,
    .cs-accent_10_border,
    .cs-accent_15_border,
    .cs-accent_20_border,
    .cs-accent_30_border,
    .cs-accent_40_border,
    .cs-accent_10_border_hover:hover,
    .cs-accent_15_border_hover:hover,
    .cs-accent_20_border_hover:hover,
    .cs-accent_30_border_hover:hover,
    .cs-accent_40_border_hover:hover,
    .tcw-header_cta,
    .tcw-header_cta:hover,
    .tcw-header_icon:hover,
    .tcw-header_cta_secondary:hover,
    .service-card button:hover,
    .view-all:hover,
    .tcw-floating-contact__icon:hover,
    .tcw-floating-panel input:focus,
    .tcw-floating-panel textarea:focus {
      border-color: var(--cs-accent) !important;
    }

    .cs-accent_border_2,
    .cs-accent_border_2_hover:hover,
    .cs-accent_10_border_2_hover:hover,
    .cs-accent_15_border_2_hover:hover,
    .cs-accent_20_border_2_hover:hover,
    .cs-accent_30_border_2_hover:hover,
    .cs-accent_40_border_2_hover:hover,
    .cs-team_member.cs-style8:hover .cs-member_image img {
      border-color: var(--cs-accent-2) !important;
    }

    .cs-accent_1_bg,
    .cs-accent_2_bg,
    .cs-accent_3_bg,
    .cs-accent_4_bg,
    .cs-accent_5_bg,
    .cs-accent_6_bg,
    .cs-accent_7_bg,
    .cs-accent_8_bg,
    .cs-accent_9_bg,
    .cs-accent_10_bg,
    .cs-accent_15_bg,
    .cs-accent_20_bg,
    .cs-accent_25_bg,
    .cs-accent_30_bg,
    .cs-accent_35_bg,
    .cs-accent_40_bg,
    .cs-accent_45_bg,
    .cs-accent_50_bg {
      background-color: var(--tcw-theme-primary-soft) !important;
    }

    .cs-accent_1_bg_2,
    .cs-accent_2_bg_2,
    .cs-accent_3_bg_2,
    .cs-accent_4_bg_2,
    .cs-accent_5_bg_2,
    .cs-accent_6_bg_2,
    .cs-accent_7_bg_2,
    .cs-accent_8_bg_2,
    .cs-accent_9_bg_2,
    .cs-accent_10_bg_2,
    .cs-accent_15_bg_2,
    .cs-accent_20_bg_2,
    .cs-accent_25_bg_2,
    .cs-accent_30_bg_2,
    .cs-accent_35_bg_2,
    .cs-accent_40_bg_2,
    .cs-accent_45_bg_2,
    .cs-accent_50_bg_2 {
      background-color: var(--tcw-theme-secondary-soft) !important;
    }

    .tcw-header_cta,
    .tcw-header_cta:hover,
    .tcw-service_icon,
    .tcw-floating-contact__quote,
    .tcw-floating-contact__quote:hover,
    .cs-btn.cs-style6.cs-accent_color .cs-btn_icon,
    .cs-btn.cs-style6.cs-accent_color:hover .cs-btn_icon,
    .cs-btn.cs-style6.cs-accent_bg .cs-btn_icon,
    .cs-btn.cs-style6.cs-accent_bg:hover .cs-btn_icon {
      background: linear-gradient(180deg, var(--cs-accent) 0%, color-mix(in srgb, var(--cs-accent) 76%, #000) 100%) !important;
    }

    .cs-btn.cs-style6.cs-accent_color_2 .cs-btn_icon,
    .cs-btn.cs-style6.cs-accent_color_2:hover .cs-btn_icon,
    .cs-btn.cs-style6.cs-accent_bg_2 .cs-btn_icon,
    .cs-btn.cs-style6.cs-accent_bg_2:hover .cs-btn_icon {
      background: linear-gradient(180deg, var(--cs-accent-2) 0%, color-mix(in srgb, var(--cs-accent-2) 76%, #000) 100%) !important;
    }

    .cs-gradient_bg_1,
    .cs-gradient_bg_2,
    .cs-shape_wrap_4 .cs-shape_4,
    .cs-hero.cs-style5 .cs-hero_img:after,
    .cs-icon_box.cs-style6:hover,
    .cs-team_member.cs-style7:hover .cs-team_member_bg,
    .tcw-feature-card:hover,
    .case-study-card:hover {
      background: linear-gradient(45deg, var(--cs-accent-2) 0%, var(--cs-accent) 100%) !important;
    }

    .cs-primary_color,
    .cs-primary_color_hover:hover,
    .cs-primary_10_color,
    .cs-primary_20_color,
    .cs-primary_30_color,
    .cs-primary_40_color,
    .cs-primary_50_color,
    .cs-primary_60_color,
    .cs-primary_70_color,
    .cs-primary_80_color,
    .cs-primary_90_color,
    .cs-nav .cs-nav_list .cs-mega-wrapper > li > a:hover,
    .tcw-footer .cs-widget_title {
      color: var(--tcw-theme-dark) !important;
    }

    .cs-primary_bg,
    .cs-primary_bg_hover:hover,
    .tcw-footer {
      background-color: var(--tcw-theme-dark) !important;
    }

    .cs-accent_bg_hover:hover,
    .cs-btn.cs-style6.cs-accent_bg:hover,
    .tcw-header_cta:hover,
    .tcw-floating-contact__quote:hover,
    .tcw-floating-whatsapp:hover,
    .tcw-review-arrow:hover,
    .tcw-blog-rail_arrow:hover,
    .tcw-mobile_group_toggle[aria-expanded="true"],
    .tcw-floating-toggle,
    .tcw-floating-submit {
      color: #fff !important;
    }

    .cs-btn.cs-style6.cs-accent_bg:hover *,
    .tcw-header_cta:hover *,
    .tcw-floating-contact__quote:hover *,
    .tcw-floating-whatsapp:hover *,
    .tcw-review-arrow:hover *,
    .tcw-blog-rail_arrow:hover * {
      color: #fff !important;
    }

    .tcw-nav_item:hover > a,
    .tcw-nav_item:hover > .tcw-dropdown_link_group,
    .tcw-nav_item:hover > .tcw-dropdown_link_group > a,
    .tcw-nav_item:hover .tcw-dropdown_toggle,
    .tcw-nav_item:focus-within > a,
    .tcw-nav_item:focus-within > .tcw-dropdown_link_group,
    .tcw-nav_item:focus-within > .tcw-dropdown_link_group > a,
    .tcw-nav_item:focus-within .tcw-dropdown_toggle,
    .tcw-nav_item.is-active > a,
    .tcw-nav_item.is-active > .tcw-dropdown_link_group,
    .tcw-nav_item.is-active > .tcw-dropdown_link_group > a,
    .tcw-nav_item.is-active .tcw-dropdown_toggle,
    .tcw-nav_item.is-open > .tcw-dropdown_link_group,
    .tcw-nav_item.is-open > .tcw-dropdown_link_group > a,
    .tcw-nav_item.is-open .tcw-dropdown_toggle {
      color: #fff !important;
    }

    .tcw-floating-contact__icon:hover,
    .tcw-floating-contact__icon:hover i {
      color: #fff !important;
    }

    @media (prefers-reduced-motion: reduce), (max-width: 767.98px) {
      *,
      *::before,
      *::after {
        animation-duration: 0.001ms !important;
        animation-iteration-count: 1 !important;
        scroll-behavior: auto !important;
        transition-duration: 0.001ms !important;
      }

      .wow {
        visibility: visible !important;
        animation-name: none !important;
      }

      .cs-parallax [class*="cs-to_"],
      .tcw-parallax-layer {
        transform: none !important;
      }
    }
  </style>
  @stack('css')

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WBPLDHC2"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @include('partials.website.header')

    <div>
        @yield('content')
    </div>

    @unless(trim($__env->yieldContent('hide_global_faqs')) === '1')
      @include('partials.website.faqs')
    @endunless

    @include('partials.website.footer')
    @include('partials.website.floating-contact')
    @include('partials.website.support-chat')
    @include('partials.website.tawk-to-chat')

    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script defer src="{{ asset('website/assets/js/plugins/jquery-3.6.0.min.js') }}"></script>
    <script defer src="{{ asset('website/assets/js/plugins/isotope.pkg.min.js') }}"></script>
    <script defer src="{{ asset('website/assets/js/plugins/jquery.slick.min.js') }}"></script>
    <script defer src="{{ asset('website/assets/js/plugins/lightgallery.min.js') }}"></script>
    <script defer src="{{ asset('website/assets/js/plugins/jquery.counter.min.js') }}"></script>
    <script defer src="{{ asset('website/assets/js/plugins/wow.min.js') }}"></script>
    <script defer src="{{ asset('website/assets/js/main.js') }}"></script>

    @stack('js')
    <script defer src="{{ asset('website/assets/js/tcw-custom.js') }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-5R1JC6PGJL');

      (function () {
        var loadTracking = function () {
          if (window.__tcwTrackingLoaded) {
            return;
          }

          window.__tcwTrackingLoaded = true;
          window.dataLayer.push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
          });

          [
            'https://www.googletagmanager.com/gtag/js?id=G-5R1JC6PGJL',
            'https://www.googletagmanager.com/gtm.js?id=GTM-WBPLDHC2',
            'https://www.clarity.ms/tag/wmtz88l2lf'
          ].forEach(function (src) {
            var script = document.createElement('script');
            script.async = true;
            script.src = src;
            document.head.appendChild(script);
          });
        };

        window.addEventListener('load', function () {
          if ('requestIdleCallback' in window) {
            window.requestIdleCallback(loadTracking, { timeout: 2500 });
          } else {
            window.setTimeout(loadTracking, 1500);
          }
        }, { once: true });
      }());
    </script>
</body>
</html>
