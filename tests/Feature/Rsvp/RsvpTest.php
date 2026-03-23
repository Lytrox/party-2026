<?php

use App\Models\Rsvp;
use App\Models\User;
use Livewire\Livewire;

test('rsvp page requires authentication', function () {
    $this->get(route('registration'))->assertRedirect(route('login'));
});

test('rsvp page is displayed for authenticated user', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('registration'))->assertOk();
});

test('rsvp can be saved', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('pages::rsvp')
        ->set('badgeName', 'John')
        ->set('attending', true)
        ->set('hasAllergies', false)
        ->set('bringing', 'A cake')
        ->set('bringingMusicEquipment', false)
        ->set('drinkingAlcohol', true)
        ->set('bringingFursuit', false)
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('rsvp-saved');

    $rsvp = $user->fresh()->rsvp;

    expect($rsvp)->not->toBeNull();
    expect($rsvp->attending)->toBeTrue();
    expect($rsvp->has_allergies)->toBeFalse();
    expect($rsvp->bringing)->toBe('A cake');
    expect($rsvp->drinking_alcohol)->toBeTrue();
    expect($rsvp->bringing_fursuit)->toBeFalse();
});

test('allergy text is required when has allergies is true', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('pages::rsvp')
        ->set('hasAllergies', true)
        ->set('allergies', '')
        ->call('save')
        ->assertHasErrors(['allergies']);
});

test('allergy text is saved when has allergies is true', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('pages::rsvp')
        ->set('badgeName', 'John')
        ->set('hasAllergies', true)
        ->set('allergies', 'Nuts and gluten')
        ->call('save')
        ->assertHasNoErrors();

    $rsvp = $user->fresh()->rsvp;

    expect($rsvp->has_allergies)->toBeTrue();
    expect($rsvp->allergies)->toBe('Nuts and gluten');
});

test('allergy text is cleared when has allergies is false', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('pages::rsvp')
        ->set('badgeName', 'John')
        ->set('hasAllergies', false)
        ->set('allergies', 'Should be cleared')
        ->call('save')
        ->assertHasNoErrors();

    expect($user->fresh()->rsvp->allergies)->toBeNull();
});

test('existing rsvp is loaded on mount', function () {
    $user = User::factory()->create();
    Rsvp::factory()->create([
        'user_id' => $user->id,
        'attending' => true,
        'has_allergies' => true,
        'allergies' => 'Lactose',
        'bringing' => 'Hookah',
        'bringing_music_equipment' => true,
        'drinking_alcohol' => false,
        'bringing_fursuit' => true,
    ]);

    $this->actingAs($user);

    Livewire::test('pages::rsvp')
        ->assertSet('attending', true)
        ->assertSet('hasAllergies', true)
        ->assertSet('allergies', 'Lactose')
        ->assertSet('bringing', 'Hookah')
        ->assertSet('bringingMusicEquipment', true)
        ->assertSet('drinkingAlcohol', false)
        ->assertSet('bringingFursuit', true);
});

test('badge name is saved', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('pages::rsvp')
        ->set('badgeName', 'Foxy')
        ->call('save')
        ->assertHasNoErrors();

    expect($user->fresh()->rsvp->badge_name)->toBe('Foxy');
});

test('badge name is loaded from existing rsvp', function () {
    $user = User::factory()->create();
    Rsvp::factory()->create(['user_id' => $user->id, 'badge_name' => 'Foxy']);

    $this->actingAs($user);

    Livewire::test('pages::rsvp')
        ->assertSet('badgeName', 'Foxy');
});

test('badge name is required', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('pages::rsvp')
        ->set('badgeName', '')
        ->call('save')
        ->assertHasErrors(['badgeName' => 'required']);
});

test('rsvp is updated when saved a second time', function () {
    $user = User::factory()->create();
    Rsvp::factory()->create(['user_id' => $user->id, 'attending' => false, 'badge_name' => 'Fox']);

    $this->actingAs($user);

    Livewire::test('pages::rsvp')
        ->set('attending', true)
        ->call('save')
        ->assertHasNoErrors();

    expect($user->fresh()->rsvp->attending)->toBeTrue();
    expect(Rsvp::where('user_id', $user->id)->count())->toBe(1);
});
