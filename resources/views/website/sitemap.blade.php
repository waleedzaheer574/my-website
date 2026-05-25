@extends('layouts.website')

@section('title', __('website.company_pages.sitemap.title'))
@section('hide_global_faqs', '1')

@section('content')
<section class="tcw-company-page">
  <div class="container">
    <div class="tcw-company-page__hero">
      <span>{{ __('website.company_pages.label') }}</span>
      <h1>{{ __('website.company_pages.sitemap.title') }}</h1>
      <p>{{ __('website.company_pages.sitemap.intro') }}</p>
    </div>

    <div class="tcw-company-page__content">
      <div class="tcw-sitemap-grid">
        <a href="{{ url('/') }}">{{ __('website.nav.home') }}</a>
        <a href="{{ url('/about') }}">{{ __('website.nav.about') }}</a>
        <a href="{{ route('website.services') }}">{{ __('website.nav.services') }}</a>
        <a href="{{ route('website.industries') }}">{{ __('website.nav.industries') }}</a>
        <a href="{{ route('website.case-studies') }}">{{ __('website.cases.highlight') }}</a>
        <a href="{{ route('website.portfolio') }}">{{ __('website.nav.portfolio') }}</a>
        <a href="{{ route('website.testimonials') }}">{{ __('website.nav.testimonials') }}</a>
        <a href="{{ route('website.blog') }}">{{ __('website.nav.blog') }}</a>
        <a href="{{ url('/contact') }}">{{ __('website.nav.contact') }}</a>
        <a href="{{ url('/privacy-policy') }}">{{ __('website.footer.privacy') }}</a>
        <a href="{{ url('/careers') }}">{{ __('website.footer.careers') }}</a>
        <a href="{{ url('/terms') }}">{{ __('website.footer.terms') }}</a>
      </div>
    </div>
  </div>
</section>
@endsection
