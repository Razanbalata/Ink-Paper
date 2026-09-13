<?php

namespace App\Services\AI;

use App\AI\Prompts\GenerateExcerptPrompt;
use App\AI\Prompts\GenerateTitlePrompt;
use App\AI\Prompts\ImproveArticlePrompt;
use App\AI\Prompts\ImproveWritingPrompt;
use App\AI\Prompts\SuggestTagsPrompt;
use App\Models\Tag;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class WritingAssistantService
{
    public function improveWriting(string $content): string
    {
        $response = Http::withToken(config('ai.groq.api_key'))
            ->acceptJson()
            ->timeout(60)
            ->post(
                config('ai.groq.base_url') . '/chat/completions',
                [
                    'model' => config('ai.groq.model'),
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => ImproveWritingPrompt::system(),
                        ],
                        [
                            'role' => 'user',
                            'content' => ImproveWritingPrompt::user($content),
                        ],
                    ],
                ]
            )
            ->throw()
            ->json();

        $result = data_get(
            $response,
            'choices.0.message.content'
        );

        if (!$result) {
            throw new RuntimeException(
                'AI returned an empty response.'
            );
        }

        return trim($result);
    }

    public function generateTitles(string $content): array
    {
        $response = Http::withToken(config('ai.groq.api_key'))
            ->acceptJson()
            ->timeout(60)
            ->post(
                config('ai.groq.base_url') . '/chat/completions',
                [
                    'model' => config('ai.groq.model'),
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => GenerateTitlePrompt::system(),
                        ],
                        [
                            'role' => 'user',
                            'content' => GenerateTitlePrompt::user($content),
                        ],
                    ],
                    'response_format' => [
                        'type' => 'json_schema',
                        'json_schema' => [
                            'name' => 'title_suggestions',
                            'strict' => true,
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'titles' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'string',
                                        ],
                                        'minItems' => 3,
                                        'maxItems' => 3,
                                    ],
                                ],
                                'required' => ['titles'],
                                'additionalProperties' => false,
                            ],
                        ],
                    ],
                ]
            )
            ->throw()
            ->json();

        $content = data_get(
            $response,
            'choices.0.message.content'
        );

        $result = json_decode($content, true);

        if (
            !is_array($result['titles'] ?? null) ||
            count($result['titles']) !== 3
        ) {
            throw new RuntimeException(
                'AI returned invalid title suggestions.'
            );
        }

        return $result['titles'];
    }

    public function generateExcerpt(string $content): string
    {
        $response = Http::withToken(config('ai.groq.api_key'))
            ->acceptJson()
            ->timeout(60)
            ->post(
                config('ai.groq.base_url') . '/chat/completions',
                [
                    'model' => config('ai.groq.model'),
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => GenerateExcerptPrompt::system(),
                        ],
                        [
                            'role' => 'user',
                            'content' => GenerateExcerptPrompt::user($content),
                        ],
                    ],
                ]
            )
            ->throw()
            ->json();

        $result = data_get(
            $response,
            'choices.0.message.content'
        );

        if (!$result) {
            throw new RuntimeException(
                'AI returned an empty excerpt.'
            );
        }

        return trim($result);
    }

    public function suggestTags(string $content): array
    {
        $response = Http::withToken(config('ai.groq.api_key'))
            ->acceptJson()
            ->timeout(60)
            ->post(
                config('ai.groq.base_url') . '/chat/completions',
                [
                    'model' => config('ai.groq.model'),
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => SuggestTagsPrompt::system(),
                        ],
                        [
                            'role' => 'user',
                            'content' => SuggestTagsPrompt::user($content),
                        ],
                    ],
                    'response_format' => [
                        'type' => 'json_schema',
                        'json_schema' => [
                            'name' => 'tag_suggestions',
                            'strict' => true,
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'tags' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'string',
                                        ],
                                        'minItems' => 3,
                                        'maxItems' => 5,
                                    ],
                                ],
                                'required' => ['tags'],
                                'additionalProperties' => false,
                            ],
                        ],
                    ],
                ]
            )
            ->throw()
            ->json();

        $content = data_get(
            $response,
            'choices.0.message.content'
        );

        $result = json_decode($content, true);

        if (
            !is_array($result['tags'] ?? null) ||
            count($result['tags']) < 3 ||
            count($result['tags']) > 5
        ) {
            throw new RuntimeException(
                'AI returned invalid tag suggestions.'
            );
        }

        return collect($result['tags'])
            ->map(function (string $tagName) {
                $tagName = trim($tagName);

                $tag = Tag::whereRaw(
                    'LOWER(name) = ?',
                    [mb_strtolower($tagName)]
                )->first();

                return [
                    'name' => $tag?->name ?? $tagName,
                    'exists' => (bool) $tag,
                    'id' => $tag?->id,
                ];
            })
            ->values()
            ->all();
    }

    public function improveArticle(string $content): array
    {
        $response = Http::withToken(config('ai.groq.api_key'))
            ->baseUrl(config('ai.groq.base_url'))
            ->timeout(60)
            ->post('/chat/completions', [
                'model' => config('ai.groq.model'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => ImproveArticlePrompt::system(),
                    ],
                    [
                        'role' => 'user',
                        'content' => ImproveArticlePrompt::user($content),
                    ],
                ],
                'temperature' => 0.3,
                'response_format' => [
                    'type' => 'json_object',
                ],
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Failed to improve article.'
            );
        }

        $result = $response->json('choices.0.message.content');

        if (!is_string($result) || trim($result) === '') {
            throw new RuntimeException(
                'AI returned an empty response.'
            );
        }

        $data = json_decode($result, true);

        if (!is_array($data)) {
            throw new RuntimeException(
                'AI returned an invalid response.'
            );
        }

        $tags = $data['tags'] ?? [];

        if (!is_array($tags)) {
            $tags = [];
        }

        $tags = collect($tags)
            ->filter(fn($tag) => is_string($tag) && trim($tag) !== '')
            ->map(fn($tag) => trim($tag))
            ->unique(fn($tag) => mb_strtolower($tag))
            ->values();

        $resolvedTags = $tags->map(function (string $tagName) {
            $tag = Tag::whereRaw(
                'LOWER(name) = ?',
                [mb_strtolower($tagName)]
            )->first();

            return [
                'name' => $tagName,
                'exists' => $tag !== null,
                'id' => $tag?->id,
            ];
        })->values()->all();

        return [
            'title' => $data['title'] ?? '',
            'excerpt' => $data['excerpt'] ?? '',
            'content' => $data['content'] ?? '',
            'tags' => $resolvedTags,
        ];
    }
}
