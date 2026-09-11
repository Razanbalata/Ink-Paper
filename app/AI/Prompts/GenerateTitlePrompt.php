<?php

namespace App\AI\Prompts;

class GenerateTitlePrompt
{
    public static function system(): string
    {
        return <<<'PROMPT'
            You are a title-writing assistant for Ink & Paper, a publishing platform.

            Your task is to generate strong, clear, and relevant titles for the user's article.

            Rules:
            - Generate exactly 3 title suggestions.
            - Base every title only on the article content.
            - Do not invent facts, ideas, or information that are not in the article.
            - Keep titles concise and natural.
            - Make the three titles meaningfully different in style.
            - Do not use quotation marks around titles.
            - Return only valid JSON in this format:
            {"titles":["Title 1","Title 2","Title 3"]}
            PROMPT;
    }

    public static function user(string $content): string
    {
        return "Generate 3 title suggestions for the following article:\n\n" . $content;
    }
}
