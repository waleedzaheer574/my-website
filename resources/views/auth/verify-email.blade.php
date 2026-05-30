<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $authLogo = \App\Models\CompanySetting::latest()->value('logo');
        $authLogoUrl = $authLogo
            ? asset('storage/' . $authLogo)
            : asset('website/assets/img/design-agency/logo.svg');
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow, noarchive">
    <title>Verify Email | Multitechwave</title>
    <link rel="icon" type="image/svg+xml" sizes="any" href="{{ asset('favicon.svg') }}?v=20260513c">
    <link rel="stylesheet" href="{{ asset('website/assets/css/auth-custom.css') }}">
</head>
<body>
    <main class="login-shell login-shell--single">
        <section class="login-panel login-panel--form login-panel--center" aria-label="Verify email">
            <div class="login-card login-card--single">
                <a class="login-logo login-logo--center" href="{{ url('/') }}">
                    <img src="{{ $authLogoUrl }}" alt="Multitechwave">
                </a>

                <h1 class="auth-heading">Verify your email</h1>
                <p class="auth-copy">We sent a verification link to <strong>{{ auth()->user()->email }}</strong> to confirm your new account.</p>

                @if(session('status'))
                    <div class="alert-success">{{ session('status') }}</div>
                @endif

                <form action="{{ route('verification.send') }}" method="POST" data-ajax-auth-form data-processing-label="Sending Link...">
                    @csrf
                    <button type="submit" class="btn">Resend Verification Email</button>
                </form>

                <div class="login-back">
                    <a href="{{ url('/') }}">Return to website</a>
                </div>
            </div>
        </section>
    </main>
    @include('auth.ajax-form-script')
</body>
</html>
