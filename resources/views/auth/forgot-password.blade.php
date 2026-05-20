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
    <title>Forgot Password | Multitechwave</title>
    <link rel="icon" type="image/svg+xml" sizes="any" href="{{ asset('favicon.svg') }}?v=20260513c">
    <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('favicon.png') }}?v=20260513c">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=20260513c">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('website/assets/css/auth-custom.css') }}">
</head>
<body>
    <main class="login-shell login-shell--single">
        <section class="login-panel login-panel--form login-panel--center" aria-label="Forgot password form">
            <div class="login-card login-card--single">
                <a class="login-logo login-logo--center" href="{{ url('/') }}">
                    <img src="{{ $authLogoUrl }}" alt="Multitechwave">
                </a>

                @if(session('status'))
                    <div class="alert-success">{{ session('status') }}</div>
                @endif

                @if($errors->any() && ! $errors->has('email'))
                    <div class="alert-error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required autofocus value="{{ old('email', $verifiedEmail ?? $otpEmail ?? '') }}" @if(isset($verifiedEmail) || isset($otpEmail)) readonly @endif>
                        @error('email')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    @isset($otpEmail)
                        <input type="hidden" name="otp_sent" value="1">

                        <div class="form-group">
                            <label for="otp">OTP</label>
                            <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter 6-digit OTP" inputmode="numeric" maxlength="6" required>
                            @error('otp')
                                <small class="field-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn">Verify OTP</button>
                    @elseif(isset($verifiedEmail))
                        <input type="hidden" name="otp_verified" value="1">

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <div class="password-field">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" required>
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

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="password-field">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password" required>
                                <button type="button" class="password-toggle" aria-label="Show password" data-password-toggle>
                                    <svg data-password-eye viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M2.25 12s3.25-6 9.75-6 9.75 6 9.75 6-3.25 6-9.75 6-9.75-6-9.75-6Z"></path>
                                        <circle cx="12" cy="12" r="3.25"></circle>
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <small class="field-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn">Reset Password</button>
                    @else
                        <button type="submit" class="btn">Verify Email</button>
                    @endif
                </form>

                <div class="login-back">
                    <a href="{{ route('login') }}">Back to login</a>
                </div>
            </div>
        </section>
    </main>
    @include('auth.password-toggle-script')
</body>
</html>
