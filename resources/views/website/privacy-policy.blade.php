@extends('layouts.website')

@section('title', __('website.company_pages.privacy.title'))
@section('hide_global_faqs', '1')

@section('content')
<section class="tcw-company-page">
  <div class="container">
    <div class="tcw-company-page__hero">
      <span>{{ __('website.company_pages.label') }}</span>
      <h1>{{ __('website.company_pages.privacy.title') }}</h1>
      <p>{{ __('website.company_pages.privacy.intro') }}</p>
    </div>

    <div class="tcw-company-page__content">
      @foreach(__('website.company_pages.privacy.sections') as $section)
        <h2>{{ $section['title'] }}</h2>
        <p>{{ $section['text'] }}</p>
      @endforeach

      <h2>{{ __('website.company_pages.privacy.contact_title') }}</h2>
      <p>{{ __('website.company_pages.privacy.contact_text') }} <a href="mailto:awaiszaheer574@gmail.com">awaiszaheer574@gmail.com</a>.</p>
    </div>
  </div>
</section>
@endsection
