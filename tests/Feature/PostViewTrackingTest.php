<?php

use App\Models\Post;
use App\Models\User;
use App\Services\ViewTrackingService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('records a view for an authenticated user', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user);

    app(ViewTrackingService::class)->track($post);

    expect($post->views()->count())->toBe(1);

    expect($post->views()->first()->user_id)
        ->toBe($user->id);
});

it('records a view for a guest', function () {
    $post = Post::factory()->create();

    app(ViewTrackingService::class)->track($post);

    expect($post->views()->count())->toBe(1);

    expect($post->views()->first()->user_id)
        ->toBeNull();

    expect($post->views()->first()->session_id)
        ->not->toBeNull();
});

it('does not record duplicate views for an authenticated user within 30 minutes', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user);

    $service = app(ViewTrackingService::class);

    $service->track($post);
    $service->track($post);

    expect($post->views()->count())->toBe(1);
});

it('does not record duplicate views for a guest within 30 minutes', function () {
    $post = Post::factory()->create();

    $service = app(ViewTrackingService::class);

    $service->track($post);
    $service->track($post);

    expect($post->views()->count())->toBe(1);
});

it('records a new view after the 30 minute cooldown', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user);

    $service = app(ViewTrackingService::class);

    $service->track($post);

    $post->views()->update([
        'created_at' => now()->subMinutes(31),
    ]);

    $service->track($post);

    expect($post->views()->count())->toBe(2);
});

it('records separate views for different authenticated users', function () {
    $userOne = User::factory()->create();
    $userTwo = User::factory()->create();
    $post = Post::factory()->create();

    $service = app(ViewTrackingService::class);

    $this->actingAs($userOne);
    $service->track($post);

    $this->actingAs($userTwo);
    $service->track($post);

    expect($post->views()->count())->toBe(2);
});

it('records a view when an authenticated user opens a published post', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('posts.show', $post->slug))
        ->assertOk();

    expect($post->views()->count())->toBe(1);

    expect($post->views()->first()->user_id)
        ->toBe($user->id);
});
it('records a view when a guest opens a published post', function () {
    $post = Post::factory()->create([
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->get(route('posts.show', $post->slug))
        ->assertOk();

    expect($post->views()->count())->toBe(1);

    expect($post->views()->first()->user_id)
        ->toBeNull();

    expect($post->views()->first()->session_id)
        ->not->toBeNull();
});
it('does not record a duplicate view when the same authenticated user refreshes the post', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->actingAs($user);

    $this->get(route('posts.show', $post->slug))
        ->assertOk();

    $this->get(route('posts.show', $post->slug))
        ->assertOk();

    expect($post->views()->count())->toBe(1);
});
it('does not record a view for an unpublished post', function () {
    $post = Post::factory()->create([
        'status' => 'draft',
        'published_at' => null,
    ]);

    $this->get(route('posts.show', $post->slug))
        ->assertNotFound();

    expect($post->views()->count())->toBe(0);
});