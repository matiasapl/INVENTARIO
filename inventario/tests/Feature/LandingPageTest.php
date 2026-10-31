<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('visitors can open the landing page while individual registration is available', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('welcome')
            ->where('canRegister', true)
            ->where('auth.user', null)
        );
});

test('authenticated visitors can open the landing page with their own account context', function () {
    $this->actingAs($user = User::factory()->create())
        ->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('welcome')
            ->where('auth.user.id', $user->id)
        );
});
