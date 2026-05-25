@extends('layouts.website')

@section('title', __('website.company_pages.careers.title'))
@section('hide_global_faqs', '1')

@section('content')
<section class="tcw-company-page">
  <div class="container">
    <div class="tcw-company-page__hero">
      <span>{{ __('website.company_pages.label') }}</span>
      <h1>{{ __('website.company_pages.careers.title') }}</h1>
      <p>{{ __('website.company_pages.careers.intro') }}</p>
    </div>

    <div class="tcw-company-page__content">
      <h2>{{ __('website.company_pages.careers.work_title') }}</h2>
      <p>{{ __('website.company_pages.careers.work_text') }}</p>

      <h2>{{ __('website.company_pages.careers.areas_title') }}</h2>
      <ul>
        @foreach(__('website.company_pages.careers.areas') as $area)
          <li>{{ $area }}</li>
        @endforeach
      </ul>

      <h2>{{ __('website.company_pages.careers.apply_title') }}</h2>
      <p>{{ __('website.company_pages.careers.apply_text') }} <a href="mailto:awaiszaheer574@gmail.com">awaiszaheer574@gmail.com</a>.</p>
    </div>
  </div>
</section>
@endsection
