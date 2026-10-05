<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a user to follow another user', function () {
    $follower = User::factory()->create();
    $following = User::factory()->create();

    $this->actingAs($follower)
        ->post(route('users.follow', $following));

    expect(
        $follower->following()
            ->whereKey($following->id)
            ->exists()
    )->toBeTrue();
});

it('allows a user to unfollow another user', function () {
    $follower = User::factory()->create();
    $following = User::factory()->create();

    $follower->following()->attach($following);

    $this->actingAs($follower)
        ->delete(route('users.unfollow', $following));

    expect(
        $follower->following()
            ->whereKey($following->id)
            ->exists()
    )->toBeFalse();
});

it('prevents a user from following themselves', function () {
    $user = User::factory()->create();

    expect(fn () => app(\App\Services\FollowService::class)
        ->follow($user, $user)
    )->toThrow(LogicException::class);
});

it('does not create duplicate follows', function () {
    $follower = User::factory()->create();
    $following = User::factory()->create();

    $service = app(\App\Services\FollowService::class);

    $service->follow($follower, $following);
    $service->follow($follower, $following);

    expect(
        $follower->following()
            ->whereKey($following->id)
            ->count()
    )->toBe(1);
});

it('returns the correct followers and following users', function () {
    $razan = User::factory()->create();
    $ahmed = User::factory()->create();

    $razan->following()->attach($ahmed);

    expect($razan->following->contains($ahmed))->toBeTrue()
        ->and($ahmed->followers->contains($razan))->toBeTrue();
});