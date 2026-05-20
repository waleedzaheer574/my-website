@extends('layouts.website')

@section('title', 'Sitemap')
@section('hide_global_faqs', '1')

@section('content')
<section class="tcw-company-page">
  <div class="container">
    <div class="tcw-company-page__hero">
      <span>Company</span>
      <h1>Sitemap</h1>
      <p>Quick links to the main Multitechwave website pages.</p>
    </div>

    <div class="tcw-company-page__content">
      <div class="tcw-sitemap-grid">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/about') }}">About Us</a>
        <a href="{{ route('website.services') }}">Services</a>
        <a href="{{ route('website.industries') }}">Industries</a>
        <a href="{{ route('website.case-studies') }}">Case Studies</a>
        <a href="{{ route('website.portfolio') }}">Portfolio</a>
        <a href="{{ route('website.testimonials') }}">Testimonials</a>
        <a href="{{ route('website.blog') }}">Blog</a>
        <a href="{{ url('/contact') }}">Contact Us</a>
        <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
        <a href="{{ url('/careers') }}">Careers</a>
        <a href="{{ url('/terms') }}">Terms</a>
      </div>
    </div>
  </div>
</section>
@endsection
