<?php

return [
    'groq' => [
        'api_key' => env('GROQ_API_KEY'),
        'model' => env('GROQ_MODEL', 'openai/gpt-oss-120b'),
        'base_url' => 'https://api.groq.com/openai/v1',
    ],
];
