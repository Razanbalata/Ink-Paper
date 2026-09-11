<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WritingAssistantTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_improve_article_writing(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'This is the improved article.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->postJson(route('ai.writing.improve'), [
                'content' => 'This is an article that needs improvement.',
            ]);

        $response
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
                'result' => 'This is the improved article.',
            ]);

        Http::assertSent(function ($request) {
            return str_contains(
                $request->url(),
                'api.groq.com/openai/v1/chat/completions'
            );
        });
    }

    public function test_user_can_generate_article_titles(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'titles' => [
                                    'Building Better Laravel Applications',
                                    'What I Learned While Building with Laravel',
                                    'Learning Laravel Through Real Projects',
                                ],
                            ]),
                        ],
                    ],
                ],
            ], 200),
        ]);

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->postJson(route('ai.writing.title'), [
                'content' => 'I am learning Laravel by building real projects.',
            ]);

        $response
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
                'titles' => [
                    'Building Better Laravel Applications',
                    'What I Learned While Building with Laravel',
                    'Learning Laravel Through Real Projects',
                ],
            ]);

        Http::assertSent(function ($request) {
            return str_contains(
                $request->url(),
                'api.groq.com/openai/v1/chat/completions'
            );
        });
    }
}
