<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
}
