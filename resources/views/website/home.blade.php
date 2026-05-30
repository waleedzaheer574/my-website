@extends('layouts.website')

@section('title', __('website.nav.home'))

@push('css')
  <link rel="preload" href="{{ asset('website/assets/img/generated/home-hero-optimized.jpg') }}" as="image" fetchpriority="high">
@endpush

@section('content')
@php
  $heroServices = $services;
  $serviceIcons = ['fa-code', 'fa-mobile-alt', 'fa-pencil-ruler', 'fa-cloud', 'fa-shield-alt', 'fa-arrow-trend-up'];
  $whyItems = $whyNexas->take(3);
  $stats = [
    ['icon' => 'fa-users', 'value' => '50+', 'label' => __('website.home.stats.clients'), 'tone' => 'blue'],
    ['icon' => 'fa-briefcase', 'value' => '120+', 'label' => __('website.home.stats.projects'), 'tone' => 'green'],
    ['icon' => 'fa-trophy', 'value' => '5+', 'label' => __('website.home.stats.experience'), 'tone' => 'blue'],
    ['icon' => 'fa-globe', 'value' => '10+', 'label' => __('website.home.stats.countries'), 'tone' => 'green'],
  ];
  $fallbackLogos = ['Google', 'Microsoft', 'Upwork', 'Fiverr', 'Clutch', 'GoodFirms', 'Shopify', 'WordPress'];
  $trustedLogoEntries = $logos->isNotEmpty() ? $logos : collect($fallbackLogos);
  $trustedLogoLoopCount = max(1, (int) ceil(12 / max(1, $trustedLogoEntries->count())));
  $dummyPortfolios = [
    [
      'title' => 'Cloud SaaS Dashboard',
      'category' => 'Web Application',
      'description' => 'A modern analytics dashboard for subscriptions, users and business performance.',
      'icon' => 'fa-chart-line',
      'tone' => 'blue',
    ],
    [
      'title' => 'Ecommerce Growth Store',
      'category' => 'Online Store',
      'description' => 'A fast storefront experience with conversion-focused product and checkout flows.',
      'icon' => 'fa-shopping-bag',
      'tone' => 'green',
    ],
    [
      'title' => 'IT Consultant Brand Site',
      'category' => 'Corporate Website',
      'description' => 'A polished service website with quote forms, service pages and portfolio sections.',
      'icon' => 'fa-laptop-code',
      'tone' => 'blue',
    ],
  ];
  $offerMeta = [
      '5-page-dynamic-website' => ['icon' => 'fa-regular fa-window-maximize', 'badge' => 'Best Seller', 'old_price' => 'AED 300', 'tone' => 'blue'],
      'ecommerce-website' => ['icon' => 'fas fa-shopping-cart', 'badge' => 'Popular', 'old_price' => 'AED 1,600', 'tone' => 'pink'],
      'laravel-saas-system' => ['icon' => 'fas fa-code', 'badge' => 'Most Popular', 'old_price' => 'AED 4,500', 'tone' => 'purple', 'featured' => true],
      'seo-starter-package' => ['icon' => 'fas fa-search-location', 'old_price' => 'AED 250', 'tone' => 'violet'],
      'mobile-app-development' => ['icon' => 'fas fa-mobile-alt', 'old_price' => 'AED 1,200', 'tone' => 'pink'],
  ];
@endphp

<main class="tcw-it-home">
  <section class="tcw-it-hero">
    <div class="container">
      <div class="tcw-it-hero-grid">
        <div class="tcw-it-hero-copy wow fadeInUp" data-wow-duration="1s">
          <span class="tcw-it-kicker">{{ __('website.home.kicker') }}</span>
          <h1>{{ __('website.home.heading') }} <span>{{ __('website.home.heading_highlight') }}</span></h1>
          <p>{{ __('website.home.intro') }}</p>
          <div class="tcw-it-actions">
            <a href="{{ route('website.services') }}" class="tcw-it-btn tcw-it-btn-primary">
              {{ __('website.home.our_services') }} <i class="fas fa-arrow-right"></i>
            </a>
            <a href="{{ route('website.portfolio') }}" class="tcw-it-btn tcw-it-btn-secondary">{{ __('website.home.view_portfolio') }}</a>
          </div>
          <div class="tcw-it-client-proof">
            <div class="tcw-it-avatars" aria-hidden="true">
              <span>TC</span>
              <span>UX</span>
              <span>SEO</span>
              <span>AI</span>
            </div>
            <strong>{{ __('website.home.happy_clients') }}</strong>
            <small>{{ __('website.home.worldwide') }}</small>
          </div>
        </div>

        <div class="tcw-it-hero-form-panel wow fadeIn" data-wow-duration="1s" data-wow-delay="0.15s">
          <div class="service-card tcw-hero_form_card">
            <div class="tcw-form_badge">{{ __('website.common.free_consultation') }}</div>
            <h3 class="form-title">{{ __('website.home.consultation_title') }}</h3>
            <p class="tcw-form_intro">{{ __('website.home.consultation_text') }}</p>

            @if(session('success'))
              <div class="alert-success">
                {{ session('success') }}
              </div>
            @endif

            @if($errors->any())
              <div class="alert-danger">
                <ul class="tcw-alert-list">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('services.store.public') }}" method="POST" id="service-request-form" data-service-request-form novalidate>
              @csrf

              <div class="row tcw-form-row">
                <div class="col-md-6">
                  <div class="tcw-form-field">
                    <input type="text" name="full_name" placeholder="{{ __('website.common.full_name') }}" value="{{ old('full_name') }}" class="@error('full_name') is-invalid @enderror" required>
                    @error('full_name') <span class="field-error">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="tcw-form-field">
                    <input type="text" name="company_name" placeholder="{{ __('website.common.company_name') }}" value="{{ old('company_name') }}" class="@error('company_name') is-invalid @enderror" required>
                    @error('company_name') <span class="field-error">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>

              <div class="row tcw-form-row">
                <div class="col-md-6">
                  <div class="tcw-form-field">
                    <input type="text" name="company_website" placeholder="{{ __('website.common.company_website') }}" value="{{ old('company_website') }}" class="@error('company_website') is-invalid @enderror">
                    @error('company_website') <span class="field-error">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="tcw-form-field">
                    <input type="email" name="company_email" placeholder="{{ __('website.common.company_email') }}" value="{{ old('company_email') }}" class="@error('company_email') is-invalid @enderror" required>
                    @error('company_email') <span class="field-error">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>

              <div class="tcw-form-field">
                <div class="phone-field-wrap">
                  <input type="tel" id="full_phone" name="phone_no" placeholder="{{ __('website.common.phone_number') }}" autocomplete="tel" value="{{ old('phone_no') }}" class="@error('phone_no') is-invalid @enderror" required>
                  <input type="hidden" name="country" id="country_name">
                </div>
                @error('phone_no') <span class="field-error">{{ $message }}</span> @enderror
              </div>

              <div class="tcw-form-field">
                <div class="tcw-service-select">
                  <select name="service_type" class="@error('service_type') is-invalid @enderror" required>
                    <option value="" disabled {{ old('service_type') ? '' : 'selected' }}>{{ __('website.common.choose_service') }}</option>
                    @foreach($services as $service)
                      <option value="{{ $service->service_title }}" {{ old('service_type') === $service->service_title ? 'selected' : '' }}>
                        {{ $service->localized('service_title') }}
                      </option>
                    @endforeach
                  </select>
                </div>
                @error('service_type') <span class="field-error">{{ $message }}</span> @enderror
              </div>

              <button type="submit">{{ __('website.common.submit_request') }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="tcw-it-section tcw-it-services">
    <div class="container">
      <div class="tcw-it-section-head text-center">
        <span>{{ __('website.home.what_we_do') }}</span>
        <h2>{{ __('website.home.our_services') }}</h2>
      </div>

      <div class="cs-slider tcw-it-service-slider" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
        <div class="cs-slider_container"
          data-rtl="{{ app()->isLocale('ar') ? '1' : '0' }}"
          data-autoplay="2400"
          data-loop="1"
          data-speed="700"
          data-center="1"
          data-variable-width="0"
          data-fade-slide="0"
          data-slides-per-view="responsive"
          data-add-slides="4"
          data-lg-slides="4"
          data-md-slides="3"
          data-sm-slides="2"
          data-xs-slides="1">
          <div class="cs-slider_wrapper">
            @forelse($heroServices as $service)
              <div class="cs-slide">
                <a href="{{ $service->detail ? route('website.service-details.show', $service->detail->slug) : route('website.services') }}" class="tcw-it-service-card">
                  <div class="tcw-it-card-icon {{ $loop->odd ? 'is-green' : 'is-blue' }}">
                    @if($service->icon)
                      <img src="{{ asset($service->icon) }}" alt="{{ $service->localized('service_title') }}" width="48" height="48" loading="lazy" decoding="async">
                    @else
                      <i class="fas {{ $serviceIcons[$loop->index] ?? 'fa-arrow-trend-up' }}"></i>
                    @endif
                  </div>
                  <h3>{{ $service->localized('service_title') }}</h3>
                  <p>{{ \Illuminate\Support\Str::limit($service->localized('service_description'), 112) }}</p>
                  <span class="tcw-it-card-arrow"><i class="fas fa-arrow-right"></i></span>
                </a>
              </div>
            @empty
              @foreach(['Web Development', 'Mobile App Development', 'UI/UX Design', 'Cloud Solutions', 'IT Consulting', 'SEO Growth Strategy'] as $label)
                <div class="cs-slide">
                  <a href="{{ route('website.services') }}" class="tcw-it-service-card">
                    <div class="tcw-it-card-icon {{ $loop->even ? 'is-green' : 'is-blue' }}">
                      <i class="fas {{ $serviceIcons[$loop->index] ?? 'fa-code' }}"></i>
                    </div>
                    <h3>{{ $label }}</h3>
                    <p>Modern, responsive and conversion-focused solutions for growing businesses.</p>
                    <span class="tcw-it-card-arrow"><i class="fas fa-arrow-right"></i></span>
                  </a>
                </div>
              @endforeach
            @endforelse
          </div>
        </div>
        <div class="cs-pagination cs-style1 cs-accent_color"></div>
      </div>
    </div>
  </section>

  <section class="tcw-it-section tcw-home-offers">
    <div class="container">
      <div class="tcw-it-section-head text-center">
        <span>{{ __('website.home.featured_offers') }}</span>
        <h2>{{ __('website.home.offers_title') }}</h2>
      </div>

      <div class="tcw-offer-grid tcw-home-premium-offer-grid">
        @php
          $homeOffers = $offers->isNotEmpty() ? $offers : collect([
            new \App\Models\Offer(['title' => '5 Page Dynamic Website', 'title_ar' => 'موقع ديناميكي من 5 صفحات', 'slug' => '5-page-dynamic-website', 'category' => 'Website Development', 'category_ar' => 'تطوير المواقع', 'description' => 'Premium business website with dynamic pages and inquiry flow.', 'description_ar' => 'موقع احترافي لأعمالك بصفحات ديناميكية ومسار واضح لاستقبال الطلبات.', 'currency' => 'AED', 'price' => 200, 'billing_cycle' => 'one_time', 'delivery_time' => '5 - 7 days', 'features' => ['Responsive pages', 'Admin editable content', 'Contact form'], 'features_ar' => ['صفحات متجاوبة', 'محتوى قابل للتعديل', 'نموذج تواصل'], 'is_popular' => true]),
            new \App\Models\Offer(['title' => 'Ecommerce Website', 'title_ar' => 'موقع تجارة إلكترونية', 'slug' => 'ecommerce-website', 'category' => 'Online Store', 'category_ar' => 'متجر إلكتروني', 'description' => 'Conversion-focused ecommerce storefront and order flow.', 'description_ar' => 'متجر إلكتروني احترافي يركز على التحويل ومسار الطلب السهل.', 'currency' => 'AED', 'price' => 1200, 'billing_cycle' => 'one_time', 'delivery_time' => '2 - 3 weeks', 'features' => ['Product catalog', 'Checkout UI', 'Order dashboard'], 'features_ar' => ['كتالوج المنتجات', 'واجهة الدفع', 'لوحة الطلبات']]),
            new \App\Models\Offer(['title' => 'SEO Starter Package', 'title_ar' => 'باقة تحسين محركات البحث', 'slug' => 'seo-starter-package', 'category' => 'SEO Services', 'category_ar' => 'خدمات SEO', 'description' => 'Starter monthly SEO setup for visibility and technical health.', 'description_ar' => 'باقة شهرية لرفع الظهور وتحسين الصحة التقنية للموقع.', 'currency' => 'AED', 'price' => 150, 'billing_cycle' => 'monthly', 'delivery_time' => 'Monthly', 'features' => ['Keyword plan', 'On-page SEO', 'Monthly report'], 'features_ar' => ['خطة كلمات مفتاحية', 'تحسين الصفحات', 'تقرير شهري']]),
            new \App\Models\Offer(['title' => 'Laravel SaaS System', 'title_ar' => 'نظام Laravel SaaS', 'slug' => 'laravel-saas-system', 'category' => 'SaaS Development', 'category_ar' => 'تطوير SaaS', 'description' => 'Custom Laravel SaaS with auth, dashboard, workflows and admin.', 'description_ar' => 'نظام Laravel SaaS مخصص مع تسجيل دخول ولوحة تحكم وإدارة سير العمل.', 'currency' => 'AED', 'price' => 3000, 'billing_cycle' => 'one_time', 'delivery_time' => '4 - 8 weeks', 'features' => ['Laravel backend', 'User dashboard', 'Admin panel'], 'features_ar' => ['خلفية Laravel', 'لوحة المستخدم', 'لوحة الإدارة']]),
          ]);
        @endphp
        @foreach($homeOffers as $offer)
          @php
            $meta = $offerMeta[$offer->slug] ?? [];
            $isFeatured = (bool) ($meta['featured'] ?? false);
            $badge = app()->getLocale() === 'ar'
              ? ($offer->is_popular ? __('website.offer_detail.popular') : null)
              : ($meta['badge'] ?? ($offer->is_popular ? 'Popular' : null));
            $icon = $meta['icon'] ?? 'fas fa-layer-group';
            $tone = $meta['tone'] ?? 'blue';
          @endphp
          <article class="tcw-offer-card tcw-premium-offer-card {{ $isFeatured ? 'is-featured' : '' }}">
            <div class="tcw-offer-card-top">
              <span class="tcw-offer-icon is-{{ $tone }}"><i class="{{ $icon }}"></i></span>
              @if($badge)
                <b class="tcw-offer-badge">{{ $badge }}</b>
              @endif
            </div>
            <h3>{{ $offer->localized('title') }}</h3>
            <p>{{ $offer->localized('description') }}</p>
            <div class="tcw-offer-price">
              <strong>{{ $offer->price_label }}</strong>
              @if(!empty($meta['old_price']))
                <small>{{ $meta['old_price'] }}</small>
              @endif
            </div>
            <small>{{ $offer->billing_label }} · {{ $offer->delivery_label }}</small>
            <ul>
              @foreach(array_slice($offer->localized('features') ?? [], 0, 5) as $feature)
                <li><i class="fas fa-check-circle"></i>{{ $feature }}</li>
              @endforeach
              @if($offer->delivery_label)
                <li><i class="fas fa-check-circle"></i>{{ $offer->delivery_label }} {{ __('website.offer_detail.delivery') }}</li>
              @endif
            </ul>
            <a href="{{ $offer->exists ? route('website.offers.show', $offer->slug) : route('website.offers') }}" class="tcw-offer-card-btn {{ $isFeatured ? 'is-hot' : '' }}">
              {{ $isFeatured ? __('website.common.get_started') : __('website.common.view_details') }}
            </a>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <section class="tcw-it-section tcw-it-proof">
    <div class="container">
      <div class="tcw-it-proof-grid">
        <div class="tcw-it-proof-copy wow fadeInUp">
          <span>{{ __('website.home.why_label') }}</span>
          <h2>{{ __('website.home.why_title') }}</h2>
          <p>{{ __('website.home.why_text') }}</p>
          <a href="{{ url('/about') }}" class="tcw-it-btn tcw-it-btn-primary">{{ __('website.home.learn_about') }}</a>
        </div>

        @foreach($stats as $stat)
          <div class="tcw-it-stat-card wow fadeInUp" data-wow-delay="{{ number_format($loop->index * 0.05, 2) }}s">
            <div class="tcw-it-stat-icon is-{{ $stat['tone'] }}"><i class="fas {{ $stat['icon'] }}"></i></div>
            <strong>{{ $stat['value'] }}</strong>
            <span>{{ $stat['label'] }}</span>
          </div>
        @endforeach
      </div>

      @if($whyItems->isNotEmpty())
        <div class="tcw-it-why-grid">
          @foreach($whyItems as $whyNexa)
            <article class="tcw-it-why-card">
              <h3>{{ $whyNexa->localized('title') }}</h3>
              <p>{{ $whyNexa->localized('description') }}</p>
            </article>
          @endforeach
        </div>
      @endif
    </div>
  </section>

  <section class="tcw-it-trusted">
    <div class="container">
      <p>{{ __('website.home.trusted') }}</p>
      <div class="cs-slider tcw-it-logo-slider">
        <div class="cs-slider_container"
          data-rtl="{{ app()->isLocale('ar') ? '1' : '0' }}"
          data-autoplay="2200"
          data-loop="1"
          data-speed="700"
          data-center="0"
          data-variable-width="0"
          data-slides-per-view="responsive"
          data-add-slides="6"
          data-lg-slides="6"
          data-md-slides="5"
          data-sm-slides="4"
          data-xs-slides="2">
          <div class="cs-slider_wrapper">
            @for($i = 0; $i < $trustedLogoLoopCount; $i++)
              @foreach($trustedLogoEntries as $logo)
                <div class="cs-slide">
                  @if(is_string($logo))
                    <div class="tcw-it-logo-text">{{ $logo }}</div>
                  @else
                    <div class="tcw-it-logo-item">
                      <img src="{{ asset('storage/' . $logo->logo) }}" alt="Partner Logo" loading="lazy" decoding="async">
                    </div>
                  @endif
                </div>
              @endforeach
            @endfor
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="tcw-it-section tcw-it-portfolio">
    <div class="container">
      <div class="tcw-it-section-head">
        <span>{{ __('website.home.selected_work') }}</span>
        <h2>{{ __('website.home.featured_portfolio') }}</h2>
      </div>
      <div class="tcw-it-portfolio-grid">
        @forelse($homePortfolios->take(4) as $portfolio)
          <a href="{{ route('website.portfolio-details.show', $portfolio->slug) }}" class="tcw-it-portfolio-card">
            <img src="{{ asset($portfolio->image) }}" alt="{{ $portfolio->localized('title') }}" loading="lazy" decoding="async">
            <div>
              <small>{{ $portfolio->localized('category') ?: __('website.portfolio_detail.project') }}</small>
              <h3>{{ $portfolio->localized('title') }}</h3>
              @if($portfolio->localized('short_description'))
                <p>{{ \Illuminate\Support\Str::limit($portfolio->localized('short_description'), 105) }}</p>
              @endif
            </div>
          </a>
        @empty
          @foreach($dummyPortfolios as $portfolio)
            <a href="{{ route('website.portfolio') }}" class="tcw-it-portfolio-card tcw-it-dummy-portfolio">
              <div class="tcw-it-portfolio-visual is-{{ $portfolio['tone'] }}">
                <i class="fas {{ $portfolio['icon'] }}"></i>
                <span></span>
                <span></span>
                <span></span>
              </div>
              <div>
                <small>{{ $portfolio['category'] }}</small>
                <h3>{{ $portfolio['title'] }}</h3>
                <p>{{ $portfolio['description'] }}</p>
              </div>
            </a>
          @endforeach
        @endforelse
      </div>
    </div>
  </section>

  @if($reviews->isNotEmpty())
    @include('partials.website.review-slider', ['reviews' => $reviews])
  @endif

  <section class="tcw-it-section tcw-blog-section">
    <div class="container">
      <div class="tcw-it-section-head">
        <span>{{ __('website.home.our_blog') }}</span>
        <h2>{{ __('website.home.all_articles') }}</h2>
      </div>
    </div>
    @include('partials.website.blog-slider', ['blogs' => $latestBlogs, 'emptyText' => __('website.common.no_blogs')])
  </section>
</main>
@endsection
