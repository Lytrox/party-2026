<?php

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyFeature(Features::twoFactorAuthentication());

    Http::fake([
        'challenges.cloudflare.com/*' => Http::response(['success' => true], 200),
    ]);
});

test('two factor challenge redirects to login when not authenticated', function () {
    $response = $this->get(route('two-factor.login'));

    $response->assertRedirect(route('login'));
});

test('two factor challenge can be rendered', function () {
    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->withTwoFactor()->create();

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
        'cf-turnstile-response' => 'test-token',
    ])->assertRedirect(route('two-factor.login'));
});
