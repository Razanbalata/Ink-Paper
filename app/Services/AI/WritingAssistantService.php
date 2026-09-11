<?php

namespace App\Services\AI;

use App\AI\Prompts\GenerateTitlePrompt;
use App\AI\Prompts\ImproveWritingPrompt;
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
        ! is_array($result['titles'] ?? null) ||
        count($result['titles']) !== 3
    ) {
        throw new RuntimeException(
            'AI returned invalid title suggestions.'
        );
    }

    return $result['titles'];
}

}
