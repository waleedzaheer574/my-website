<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthVerificationAjaxTest extends TestCase
{
    use RefreshDatabase;

    public function test_ajax_registration_sends_a_verification_email_and_redirects_to_notice(): void
    {
        Notification::fake();

        $response = $this->postJson(route('register.post'), [
            'name' => 'New Client',
            'email' => 'new-client@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'new-client@example.com')->firstOrFail();

        $response
            ->assertCreated()
            ->assertJsonPath('redirect', route('verification.notice'));
        $this->assertFalse($user->hasVerifiedEmail());
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_new_unverified_user_is_stopped_from_submitting_a_service_request(): void
    {
        $user = User::factory()->unverified()->create(['role' => 'user']);

        $response = $this->actingAs($user)->postJson(route('services.store.public'), []);

        $response
            ->assertForbidden()
            ->assertJsonPath('redirect', route('verification.notice'));
    }

    public function test_new_unverified_user_is_redirected_until_one_time_verification_is_completed(): void
    {
        $user = User::factory()->unverified()->create(['role' => 'user']);

        $this->actingAs($user)
            ->get(route('website.quote-generator'))
            ->assertRedirect(route('verification.notice'));
    }

    public function test_verified_user_logs_in_without_another_verification_redirect(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'password' => 'password123',
        ]);

        $this->postJson(route('login.post'), [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertJsonPath('redirect', route('user.dashboard'));
    }
}
