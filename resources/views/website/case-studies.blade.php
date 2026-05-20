@extends('layouts.website')

@section('content')
  <div class="cs-hero cs-style8 cs-type1 cs-center text-center">
    <div class="container">
      <div class="cs-hero_text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
        <h1 class="cs-hero_title">Selected <b class="cs-accent_color">Case Studies</b></h1>
        <a href="#page-content" class="cs-down_btn cs-accent_color cs-accent_color_2_hover cs-smoth_scroll"><i class="fas fa-angle-down"></i></a>
      </div>
    </div>
    <div class="cs-hero_blur_shape">
      <div><img src="{{ asset('website/assets/img/design-agency/hero-blur-shape.png') }}" alt="" width="720" height="720" loading="lazy" decoding="async"></div>
    </div>
  </div>

  <div id="page-content" class="case-study-page cs-bg" data-src="{{ asset('website/assets/img/design-agency/icon-box-bg.jpg') }}">
    <div class="cs-height_140 cs-height_lg_80"></div>
    <div class="container">
      <div class="cs-section_heading cs-style2 cs-size2 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
        <div class="cs-section_subtitle">Recent Work</div>
        <h2 class="cs-section_title">How strategy turned into <b class="cs-accent_color">measurable growth</b></h2>
      </div>
      <div class="cs-height_70 cs-height_lg_50"></div>

      <div class="row case-study-grid">
        @forelse ($caseStudies as $caseStudy)
          <div class="col-lg-4 col-md-6">
            <article class="case-study-card wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
              <div class="case-study-card_media">
                @if($caseStudy->image)
                  <img src="{{ asset($caseStudy->image) }}" alt="{{ $caseStudy->title }}" width="560" height="360" loading="lazy" decoding="async">
                @else
                  <div class="case-study-card_placeholder">
                    <i class="fas fa-chart-line"></i>
                  </div>
                @endif
                <span class="case-study-card_badge">{{ $caseStudy->category ?: 'Case Study' }}</span>
              </div>

              <div class="case-study-card_body">
                @if($caseStudy->result)
                  <div class="case-study-card_result">{{ $caseStudy->result }}</div>
                @endif
                <h3 class="case-study-card_title">{{ $caseStudy->title }}</h3>
                <p class="case-study-card_text">{{ $caseStudy->summary }}</p>
                <a href="{{ url('/contact') }}" class="case-study-card_link">
                  Discuss Similar Project <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </article>
            <div class="cs-height_30 cs-height_lg_30"></div>
          </div>
        @empty
          <div class="col-12">
            <div class="case-study-empty">Case studies will appear here after you add them from the dashboard.</div>
          </div>
        @endforelse
      </div>

      @if($caseStudies->hasPages())
        <div class="cs-height_40 cs-height_lg_40"></div>
        <div class="cs-post_pagination cs-style2 cs-center cs-medium cs-primary_color">
          <ul class="page-numbers">
            @if($caseStudies->onFirstPage())
              <li><span class="page-number">Prev</span></li>
            @else
              <li><a class="page-number" href="{{ $caseStudies->previousPageUrl() }}">Prev</a></li>
            @endif

            @foreach($caseStudies->getUrlRange(1, $caseStudies->lastPage()) as $page => $url)
              <li>
                @if($page === $caseStudies->currentPage())
                  <span class="page-number current cs-accent_color">{{ $page }}</span>
                @else
                  <a class="page-number" href="{{ $url }}">{{ $page }}</a>
                @endif
              </li>
            @endforeach

            @if($caseStudies->hasMorePages())
              <li><a class="next page-number" href="{{ $caseStudies->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a></li>
            @else
              <li><span class="page-number"><i class="fas fa-angle-right"></i></span></li>
            @endif
          </ul>
        </div>
      @endif
    </div>
    <div class="cs-height_110 cs-height_lg_70"></div>
  </div>
@endsection
