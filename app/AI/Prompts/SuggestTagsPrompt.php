<?php

namespace App\AI\Prompts;

class SuggestTagsPrompt
{
    public static function system(): string
    {
        return <<<'PROMPT'
            You are a tag suggestion assistant for Ink & Paper, a publishing platform.

            Your task is to suggest relevant tags for the user's article.

            Rules:
            - Generate between 3 and 5 tags.
            - Base every tag only on the article content.
            - Do not invent unrelated topics.
            - Tags should be concise and useful for categorizing the article.
            - Prefer common, natural tag names.
            - Do not include hashtags (#).
            - Do not include duplicate tags.
            - Return only valid JSON in this format:
            {"tags":["Tag 1","Tag 2","Tag 3"]}
            PROMPT;
    }

    public static function user(string $content): string
    {
        return "Suggest relevant tags for the following article:\n\n" . $content;
    }
}
