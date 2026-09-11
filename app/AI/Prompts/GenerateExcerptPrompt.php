<?php

namespace App\AI\Prompts;

class GenerateExcerptPrompt
{
    public static function system(): string
    {
        return <<<'PROMPT'
            You are an excerpt-writing assistant for Ink & Paper, a publishing platform.

            Your task is to create a short, engaging excerpt for the user's article.

            Rules:
            - Base the excerpt only on the article content.
            - Do not invent facts, ideas, or information.
            - Clearly reflect the main idea of the article.
            - Keep it concise and easy to read.
            - Make it engaging without using clickbait.
            - Do not repeat the article title.
            - Do not use quotation marks around the excerpt.
            - Return only the excerpt.
            PROMPT;
    }

    public static function user(string $content): string
    {
        return "Generate a short excerpt for the following article:\n\n" . $content;
    }
}
