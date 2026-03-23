<?php

use App\Models\User;
use Livewire\Livewire;

test('language settings page is accessible', function () {
    $this->actingAs(User::factory()->create())->get(route('language.edit'))->assertOk();
});

test('user can update preferred locale to english', function () {
    $user = User::factory()->create(['preferred_locale' => 'de']);
    $this->actingAs($user);

    Livewire::test('pages::settings.language')
        ->set('locale', 'en')
        ->call('updateLocale')
        ->assertHasNoErrors()
        ->assertDispatched('locale-updated');

    expect($user->fresh()->preferred_locale)->toBe('en');
});

test('user can update preferred locale to german', function () {
    $user = User::factory()->create(['preferred_locale' => 'en']);
    $this->actingAs($user);

    Livewire::test('pages::settings.language')
        ->set('locale', 'de')
        ->call('updateLocale')
        ->assertHasNoErrors();

    expect($user->fresh()->preferred_locale)->toBe('de');
});

test('invalid locale is rejected', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('pages::settings.language')
        ->set('locale', 'fr')
        ->call('updateLocale')
        ->assertHasErrors(['locale']);
});

test('locale middleware sets app locale from user preferred locale', function () {
    $user = User::factory()->create(['preferred_locale' => 'en']);

    $this->actingAs($user)->get(route('dashboard'));

    expect(app()->getLocale())->toBe('en');
});

test('locale defaults to app locale when user has no preference', function () {
    $user = User::factory()->create(['preferred_locale' => null]);

    Livewire::test('pages::settings.language')
        ->assertSet('locale', app()->getLocale());
});
