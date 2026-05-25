@extends('layouts.website')

@section('title', __('website.client.subscriptions'))
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat{display:none!important}</style>
@endpush

@section('content')
@php($activeClientNav = 'subscriptions')
@php($clientHeaderTitle = __('website.client.subscriptions'))
@php($clientHeaderSubtitle = __('website.client.subscriptions_subtitle'))
<main class="tcw-client-dashboard tcw-premium-client-dashboard">
  @include('user.partials.client-sidebar')
  <section class="tcw-client-main">
    @include('user.partials.client-header')
    <section class="tcw-client-panel">
      <div class="tcw-client-panel-head">
        <h2>{{ __('website.client.subscriptions') }}</h2>
        <a href="{{ route('website.offers') }}">{{ __('website.client.browse_offers') }}</a>
      </div>
      <div class="tcw-client-grid-list">
        @forelse($subscriptions as $subscription)
          @php($subscriptionStatusKey = 'website.client.status_labels.'.$subscription->status)
          @php($billingCycleKey = 'website.offers.'.$subscription->billing_cycle)
          <article>
            <i class="fas fa-sync-alt"></i>
            <div>
              <strong>{{ $subscription->offer?->localized('title') }}</strong>
              <span>{{ __($subscriptionStatusKey) !== $subscriptionStatusKey ? __($subscriptionStatusKey) : ucfirst(str_replace('_', ' ', $subscription->status)) }} · {{ __($billingCycleKey) !== $billingCycleKey ? __($billingCycleKey) : ucfirst(str_replace('_', ' ', $subscription->billing_cycle)) }}</span>
              <small>{{ $subscription->currency }} {{ number_format($subscription->amount) }}{{ $subscription->renews_at ? ' · '.__('website.client.renews', ['date' => $subscription->renews_at->locale(app()->getLocale())->translatedFormat('M d, Y')]) : '' }}</small>
            </div>
          </article>
        @empty
          <p>{{ __('website.client.no_subscriptions') }}</p>
        @endforelse
      </div>
      {{ $subscriptions->links() }}
    </section>
  </section>
  @include('user.partials.client-mobile-nav')
</main>
@endsection

@push('js')
  @include('user.partials.client-shell-script')
@endpush
