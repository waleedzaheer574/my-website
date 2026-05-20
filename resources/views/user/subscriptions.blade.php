@extends('layouts.website')

@section('title', 'Subscriptions')
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat{display:none!important}</style>
@endpush

@section('content')
@php($activeClientNav = 'subscriptions')
@php($clientHeaderTitle = 'Subscriptions')
@php($clientHeaderSubtitle = 'Manage recurring packages and active service plans.')
<main class="tcw-client-dashboard tcw-premium-client-dashboard">
  @include('user.partials.client-sidebar')
  <section class="tcw-client-main">
    @include('user.partials.client-header')
    <section class="tcw-client-panel">
      <div class="tcw-client-panel-head">
        <h2>Subscriptions</h2>
        <a href="{{ route('website.offers') }}">Browse offers</a>
      </div>
      <div class="tcw-client-grid-list">
        @forelse($subscriptions as $subscription)
          <article>
            <i class="fas fa-sync-alt"></i>
            <div>
              <strong>{{ $subscription->offer?->title }}</strong>
              <span>{{ strtoupper($subscription->status) }} · {{ ucfirst(str_replace('_', ' ', $subscription->billing_cycle)) }}</span>
              <small>{{ $subscription->currency }} {{ number_format($subscription->amount) }}{{ $subscription->renews_at ? ' · renews '.$subscription->renews_at->format('M d, Y') : '' }}</small>
            </div>
          </article>
        @empty
          <p>No subscriptions yet.</p>
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
