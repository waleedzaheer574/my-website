@extends('layouts.website')

@section('content')
<main class="tcw-blog-page">
  <!-- Start Hero -->
  <div class="cs-hero cs-style8 cs-type1 cs-center text-center" data-src="{{ asset('website/assets/img/design-agency/icon-box-bg2.jpg') }}">
    <div class="container">
      <div class="cs-hero_text">
        <h1 class="cs-hero_title"><b class="cs-accent_color">{{ __('website.blog.title') }}</b></h1>
        <a href="#blog" class="cs-down_btn cs-accent_color cs-accent_color_2_hover cs-smoth_scroll"><i class="fas fa-angle-down"></i></a>
      </div>
    </div>
    <div class="cs-hero_blur_shape">
      <div class=""><img src="{{ asset('website/assets/img/design-agency/hero-blur-shape.png') }}" alt="" width="720" height="720" loading="lazy" decoding="async"></div>
    </div>
  </div>
  <!-- End Hero -->

  <!-- Start Blog -->
  <section id="blog" class="tcw-blog-section tcw-section-white">
    <div class="cs-height_140 cs-height_lg_80"></div>
    <div class="container wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
      <div class="cs-section_heading cs-style2 cs-size2">
        <div class="cs-section_subtitle">{{ __('website.blog.label') }}</div>
        <h2 class="cs-section_title cs-medium">{{ __('website.blog.heading') }} <b class="cs-accent_color cs-with_bar">
          {{ __('website.blog.heading_highlight') }}
          <svg width="208" height="11" viewBox="0 0 208 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="cs-accent_color_2">
            <path d="M8.90002 10.1C72.2 10.6 135.6 10.7 198.9 10.5C200.8 10.5 200.8 7.49998 198.9 7.49998C135.6 7.79998 72.2 7.69998 8.90002 7.09998C6.90002 7.09998 6.90002 10.1 8.90002 10.1Z" fill="currentColor"/>
            <path d="M1.90002 3.79999C69.9 3.79999 137.9 4.09999 205.9 4.89999C207.8 4.89999 207.8 1.89999 205.9 1.89999C137.9 1.19999 69.9 0.799988 1.90002 0.799988C-0.0999756 0.799988 -0.0999756 3.79999 1.90002 3.79999Z" fill="currentColor"/>
          </svg>
        </b></h2>
      </div>
      <div class="cs-height_90 cs-height_lg_50"></div>
    </div>

    @include('partials.website.blog-slider', ['blogs' => $blogs])

    <div class="cs-height_140 cs-height_lg_80"></div>
  </section>
  <!-- End Blog -->
</main>
@endsection
