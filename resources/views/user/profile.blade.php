@extends('layouts.website')

@section('title', 'Account Settings')
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat{display:none!important}</style>
@endpush

@section('content')
  @php($activeClientNav = 'settings')
  @php($clientHeaderTitle = 'Account Settings')
  @php($clientHeaderSubtitle = 'Manage your profile information and password.')
  <main class="tcw-client-dashboard tcw-premium-client-dashboard tcw-account-dashboard">
    @include('user.partials.client-sidebar')

    <section class="tcw-client-main tcw-account-main">
      @include('user.partials.client-header')

      <div class="tcw-settings-hero">
        <div>
          <span>Profile center</span>
          <h1>Account Settings</h1>
          <p>Keep your profile secure, update account details, and jump back to the website anytime.</p>
        </div>
        <a href="{{ route('website.home') }}"><i class="fas fa-globe"></i> Back to Website</a>
      </div>

      <div class="tcw-settings-overview">
        <article>
          <i class="far fa-user"></i>
          <div><span>Profile</span><strong>{{ $user->name }}</strong></div>
        </article>
        <article>
          <i class="far fa-envelope"></i>
          <div><span>Email</span><strong>{{ $user->email }}</strong></div>
        </article>
        <article>
          <i class="fas fa-shield-alt"></i>
          <div><span>Security</span><strong>Password protected</strong></div>
        </article>
      </div>

      <div class="tcw-account-grid">
        <article class="tcw-account-card tcw-settings-card">
          <header>
            <div>
              <h2>Profile Information</h2>
              <p>Update your personal information</p>
            </div>
            <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
          </header>

          <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <label>
              <span>Full Name</span>
              <div><i class="far fa-user"></i><input type="text" name="name" value="{{ old('name', $user->name) }}" required></div>
            </label>
            <label>
              <span>Email Address</span>
              <div><i class="far fa-envelope"></i><input type="email" name="email" value="{{ old('email', $user->email) }}" required></div>
            </label>
            <aside>
              <strong><i class="far fa-info-circle"></i> Keep your information up to date</strong>
              <p>Ensure your email address is correct to receive important updates and notifications.</p>
            </aside>
            <button type="submit"><i class="far fa-save"></i> Save Profile</button>
          </form>
        </article>

        <article class="tcw-account-card tcw-settings-card">
          <header>
            <div>
              <h2>Change Password</h2>
              <p>Update your password to keep your account secure</p>
            </div>
            <span><i class="fas fa-lock"></i></span>
          </header>

          <form action="{{ route('user.profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')
            <label>
              <span>Current Password</span>
              <div><i class="fas fa-lock"></i><input type="password" name="current_password" placeholder="Enter your current password" required></div>
            </label>
            <label>
              <span>New Password</span>
              <div><i class="fas fa-lock"></i><input type="password" name="password" placeholder="Enter your new password" required></div>
            </label>
            <label>
              <span>Confirm Password</span>
              <div><i class="fas fa-lock"></i><input type="password" name="password_confirmation" placeholder="Confirm your new password" required></div>
            </label>
            <aside class="tcw-password-tips">
              <strong><i class="fas fa-shield-alt"></i> Password Security Tips</strong>
              <p>Use at least 8 characters</p>
              <p>Include uppercase, lowercase, numbers & symbols</p>
              <p>Avoid common passwords</p>
            </aside>
            <button type="submit"><i class="fas fa-lock"></i> Update Password</button>
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
