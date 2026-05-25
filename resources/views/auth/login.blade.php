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
    <title>Login | Multitechwave</title>
    <link rel="icon" type="image/svg+xml" sizes="any" href="{{ asset('favicon.svg') }}?v=20260513c">
    <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('favicon.png') }}?v=20260513c">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=20260513c">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('website/assets/css/auth-custom.css') }}">
</head>
<body>
    <main class="login-shell login-shell--single">
        <section class="login-panel login-panel--form login-panel--center" aria-label="Login form">
            <div class="login-card login-card--single">
                <a class="login-logo login-logo--center" href="{{ url('/') }}">
                    <img src="{{ $authLogoUrl }}" alt="Multitechwave">
                </a>

            @if(session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any() && ! $errors->has('email') && ! $errors->has('password'))
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

                <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required autofocus value="{{ old('email') }}">
                    @error('email')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-field">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                        <button type="button" class="password-toggle" aria-label="Show password" data-password-toggle>
                            <svg data-password-eye viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M2.25 12s3.25-6 9.75-6 9.75 6 9.75 6-3.25 6-9.75 6-9.75-6-9.75-6Z"></path>
                                <circle cx="12" cy="12" r="3.25"></circle>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-footer">
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                </div>

                    <button type="submit" class="btn">Sign In</button>
                </form>

                <div class="login-back">
                    <a href="{{ route('register') }}">Create account</a>
                </div>
            </div>
        </section>
    </main>
    @include('auth.password-toggle-script')
</body>
</html>
