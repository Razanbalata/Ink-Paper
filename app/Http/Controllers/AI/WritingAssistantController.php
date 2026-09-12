<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Services\AI\WritingAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WritingAssistantController extends Controller
{
    public function improve(
        Request $request,
        WritingAssistantService $writingAssistant
    ): JsonResponse {
        $validated = $request->validate([
            'content' => ['required', 'string', 'min:10'],
        ]);

        $result = $writingAssistant->improveWriting(
            $validated['content']
        );

        return response()->json([
            'success' => true,
            'result' => $result,
        ]);
    }

    public function title(
        Request $request,
        WritingAssistantService $writingAssistant
    ): JsonResponse {
        $validated = $request->validate([
            'content' => ['required', 'string', 'min:10'],
        ]);

        $titles = $writingAssistant->generateTitles(
            $validated['content']
        );

        return response()->json([
            'success' => true,
            'titles' => $titles,
        ]);
    }

    public function excerpt(
        Request $request,
        WritingAssistantService $writingAssistant
    ): JsonResponse {
        $validated = $request->validate([
            'content' => ['required', 'string', 'min:10'],
        ]);

        $excerpt = $writingAssistant->generateExcerpt(
            $validated['content']
        );

        return response()->json([
            'success' => true,
            'excerpt' => $excerpt,
        ]);
    }

    public function tags(
        Request $request,
        WritingAssistantService $writingAssistant
    ): JsonResponse {
        $validated = $request->validate([
            'content' => ['required', 'string', 'min:10'],
        ]);

        $tags = $writingAssistant->suggestTags(
            $validated['content']
        );

        return response()->json([
            'success' => true,
            'tags' => $tags,
        ]);
    }
}
