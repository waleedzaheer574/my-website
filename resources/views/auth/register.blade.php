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
    <title>Create Account | Multitechwave</title>
    <link rel="icon" type="image/svg+xml" sizes="any" href="{{ asset('favicon.svg') }}?v=20260513c">
    <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('favicon.png') }}?v=20260513c">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=20260513c">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('website/assets/css/auth-custom.css') }}">
</head>
<body>
    <main class="login-shell login-shell--single">
        <section class="login-panel login-panel--form login-panel--center" aria-label="Register form">
            <div class="login-card login-card--single">
                <a class="login-logo login-logo--center" href="{{ url('/') }}">
                    <img src="{{ $authLogoUrl }}" alt="Multitechwave">
                </a>

                @if($errors->any())
                    <div class="alert-error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required autofocus value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-field">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Create password" required>
                            <button type="button" class="password-toggle" aria-label="Show password" data-password-toggle>
                                <svg data-password-eye viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M2.25 12s3.25-6 9.75-6 9.75 6 9.75 6-3.25 6-9.75 6-9.75-6-9.75-6Z"></path>
                                    <circle cx="12" cy="12" r="3.25"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="password-field">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password" required>
                            <button type="button" class="password-toggle" aria-label="Show password" data-password-toggle>
                                <svg data-password-eye viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M2.25 12s3.25-6 9.75-6 9.75 6 9.75 6-3.25 6-9.75 6-9.75-6-9.75-6Z"></path>
                                    <circle cx="12" cy="12" r="3.25"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn">Create Account</button>
                </form>

                <div class="login-back">
                    <a href="{{ route('login') }}">Sign in</a>
                </div>
            </div>
        </section>
    </main>
    @include('auth.password-toggle-script')
</body>
</html>
