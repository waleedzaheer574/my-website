@extends('layouts.website')

@section('title', __('website.client.account_settings'))
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat{display:none!important}</style>
@endpush

@section('content')
  @php($activeClientNav = 'settings')
  @php($clientHeaderTitle = __('website.client.account_settings'))
  @php($clientHeaderSubtitle = __('website.client.settings_subtitle'))
  <main class="tcw-client-dashboard tcw-premium-client-dashboard tcw-account-dashboard">
    @include('user.partials.client-sidebar')

    <section class="tcw-client-main tcw-account-main">
      @include('user.partials.client-header')

      <div class="tcw-settings-hero">
        <div>
          <span>{{ __('website.client.profile_center') }}</span>
          <h1>{{ __('website.client.account_settings') }}</h1>
          <p>{{ __('website.client.settings_intro') }}</p>
        </div>
        <a href="{{ route('website.home') }}"><i class="fas fa-globe"></i> {{ __('website.client.back_website') }}</a>
      </div>

      <div class="tcw-settings-overview">
        <article>
          <i class="far fa-user"></i>
          <div><span>{{ __('website.client.profile') }}</span><strong>{{ $user->name }}</strong></div>
        </article>
        <article>
          <i class="far fa-envelope"></i>
          <div><span>{{ __('website.client.email') }}</span><strong>{{ $user->email }}</strong></div>
        </article>
        <article>
          <i class="fas fa-shield-alt"></i>
          <div><span>{{ __('website.client.security') }}</span><strong>{{ __('website.client.password_protected') }}</strong></div>
        </article>
      </div>

      <div class="tcw-account-grid">
        <article class="tcw-account-card tcw-settings-card">
          <header>
            <div>
              <h2>{{ __('website.client.profile_information') }}</h2>
              <p>{{ __('website.client.update_personal') }}</p>
            </div>
            <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
          </header>

          <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <label>
              <span>{{ __('website.client.full_name') }}</span>
              <div><i class="far fa-user"></i><input type="text" name="name" value="{{ old('name', $user->name) }}" required></div>
            </label>
            <label>
              <span>{{ __('website.client.email_address') }}</span>
              <div><i class="far fa-envelope"></i><input type="email" name="email" value="{{ old('email', $user->email) }}" required></div>
            </label>
            <aside>
              <strong><i class="far fa-info-circle"></i> {{ __('website.client.keep_updated') }}</strong>
              <p>{{ __('website.client.email_notice') }}</p>
            </aside>
            <button type="submit"><i class="far fa-save"></i> {{ __('website.client.save_profile') }}</button>
          </form>
        </article>

        <article class="tcw-account-card tcw-settings-card">
          <header>
            <div>
              <h2>{{ __('website.client.change_password') }}</h2>
              <p>{{ __('website.client.password_intro') }}</p>
            </div>
            <span><i class="fas fa-lock"></i></span>
          </header>

          <form action="{{ route('user.profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')
            <label>
              <span>{{ __('website.client.current_password') }}</span>
              <div><i class="fas fa-lock"></i><input type="password" name="current_password" placeholder="{{ __('website.client.enter_current') }}" required></div>
            </label>
            <label>
              <span>{{ __('website.client.new_password') }}</span>
              <div><i class="fas fa-lock"></i><input type="password" name="password" placeholder="{{ __('website.client.enter_new') }}" required></div>
            </label>
            <label>
              <span>{{ __('website.client.confirm_password') }}</span>
              <div><i class="fas fa-lock"></i><input type="password" name="password_confirmation" placeholder="{{ __('website.client.confirm_new') }}" required></div>
            </label>
            <aside class="tcw-password-tips">
              <strong><i class="fas fa-shield-alt"></i> {{ __('website.client.password_tips') }}</strong>
              <p>{{ __('website.client.tip_length') }}</p>
              <p>{{ __('website.client.tip_characters') }}</p>
              <p>{{ __('website.client.tip_avoid') }}</p>
            </aside>
            <button type="submit"><i class="fas fa-lock"></i> {{ __('website.client.update_password') }}</button>
          </form>
        </article>
      </div>
    </section>

    @include('user.partials.client-mobile-nav')
  </main>
@endsection

@push('js')
  @include('user.partials.client-shell-script')
@endpush
