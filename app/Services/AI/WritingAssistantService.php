<?php

namespace App\Services\AI;

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
}
