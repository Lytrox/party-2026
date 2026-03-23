<?php

use App\Models\User;

test('non-admin cannot access filament admin panel', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)->get('/admin')->assertForbidden();
});

test('admin can access filament admin panel', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)->get('/admin')->assertOk();
});

test('admin link is visible in sidebar for admin users', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)->get(route('dashboard'))->assertSee('/admin');
});

test('admin link is not visible for regular users', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)->get(route('dashboard'))->assertDontSee('/admin');
});
