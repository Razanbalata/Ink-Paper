<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Tag;
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

    public function test_user_can_suggest_article_tags(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'tags' => [
                                    'Laravel',
                                    'PHP',
                                    'AI',
                                    'Web Development',
                                ],
                            ]),
                        ],
                    ],
                ],
            ], 200),
        ]);

        Tag::create([
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);

        Tag::create([
            'name' => 'PHP',
            'slug' => 'php',
        ]);

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->postJson(route('ai.writing.tags'), [
                'content' => 'I am learning Laravel and building backend applications with PHP and AI.',
            ]);

        $response
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonPath('tags.0.name', 'Laravel')
            ->assertJsonPath('tags.0.exists', true)
            ->assertJsonPath('tags.1.name', 'PHP')
            ->assertJsonPath('tags.1.exists', true)
            ->assertJsonPath('tags.2.name', 'AI')
            ->assertJsonPath('tags.2.exists', false)
            ->assertJsonPath('tags.3.name', 'Web Development')
            ->assertJsonPath('tags.3.exists', false);
    }

    public function test_user_can_improve_an_entire_article(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'title' => 'Building Better Laravel Applications',
                                'excerpt' => 'A practical look at building Laravel applications.',
                                'content' => 'Improved article content with better clarity and flow.',
                                'category' => [
                                    'id' => 1,
                                    'name' => 'Web Development',
                                ],
                                'tags' => [
                                    'Laravel',
                                    'PHP',
                                    'AI',
                                ],
                            ]),
                        ],
                    ],
                ],
            ], 200),
        ]);

        Category::create([
            'id' => 1,
            'name' => 'Web Development',
            'slug' => 'web-development',
        ]);

        Tag::create([
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);

        Tag::create([
            'name' => 'PHP',
            'slug' => 'php',
        ]);

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->postJson(
                route('ai.writing.improve-article'),
                [
                    'content' => 'I am learning Laravel and building applications with PHP and AI.',
                ]
            );

        $response
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonPath(
                'article.title',
                'Building Better Laravel Applications'
            )
            ->assertJsonPath(
                'article.excerpt',
                'A practical look at building Laravel applications.'
            )
            ->assertJsonPath(
                'article.content',
                'Improved article content with better clarity and flow.'
            )
            ->assertJsonPath(
                'article.category.id',
                1
            )
            ->assertJsonPath(
                'article.category.name',
                'Web Development'
            )
            ->assertJsonPath(
                'article.tags.0.name',
                'Laravel'
            )
            ->assertJsonPath(
                'article.tags.0.exists',
                true
            )
            ->assertJsonPath(
                'article.tags.1.name',
                'PHP'
            )
            ->assertJsonPath(
                'article.tags.1.exists',
                true
            )
            ->assertJsonPath(
                'article.tags.2.name',
                'AI'
            )
            ->assertJsonPath(
                'article.tags.2.exists',
                false
            )
            ->assertJsonPath(
                'article.tags.2.id',
                null
            );
    }

    public function test_user_can_expand_content(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Laravel is a powerful framework for building modern web applications. It provides developers with a clean structure and useful tools that make development easier and more organized.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->postJson(
                route('ai.writing.expand'),
                [
                    'content' => 'Laravel is a powerful framework.',
                ]
            );

        $response
            ->assertSuccessful()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonPath(
                'result',
                'Laravel is a powerful framework for building modern web applications. It provides developers with a clean structure and useful tools that make development easier and more organized.'
            );
    }
}
