@extends('layouts.admin')

@section('title', 'Profile')
@section('body_class', 'admin-dashboard-theme admin-profile-theme')
@section('header')
    <h2>Profile Settings</h2>
@endsection

@section('content')
    <section class="admin-profile-grid">
        <article class="admin-profile-card">
            <header>
                <i></i>
                <div>
                    <h3>Profile Information</h3>
                    <p>Apna naam aur email yahan update kar sakte hain.</p>
                </div>
            </header>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="input-error">{{ $message }}</div>@enderror
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="input-error">{{ $message }}</div>@enderror
                <button type="submit">Save Profile</button>
            </form>
        </article>

        <article class="admin-profile-card is-password">
            <header>
                <i></i>
                <div>
                    <h3>Update Password</h3>
                    <p>Security strong rakhne ke liye current password confirm karke naya password set karein.</p>
                </div>
            </header>
            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <label for="current_password">Current Password</label>
                <div class="password-field">
                    <input type="password" id="current_password" name="current_password" placeholder="Enter current password" required>
                    <button type="button" class="password-toggle" data-target="current_password" aria-label="Show current password"><i class="fas fa-eye"></i></button>
                </div>
                @error('current_password')<div class="input-error">{{ $message }}</div>@enderror
                <label for="password">New Password</label>
                <div class="password-field">
                    <input type="password" id="password" name="password" placeholder="Enter new password" required>
                    <button type="button" class="password-toggle" data-target="password" aria-label="Show new password"><i class="fas fa-eye"></i></button>
                </div>
                @error('password')<div class="input-error">{{ $message }}</div>@enderror
                <label for="password_confirmation">Confirm New Password</label>
                <div class="password-field">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                    <button type="button" class="password-toggle" data-target="password_confirmation" aria-label="Show password confirmation"><i class="fas fa-eye"></i></button>
                </div>
                <button type="submit">Update Password</button>
            </form>
        </article>
    </section>
@endsection
