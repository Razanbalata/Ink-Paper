<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AITagController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
            ],
        ]);

        $name = trim($validated['name']);

        /*
         * |--------------------------------------------------------------------------
         * | Check if the tag already exists
         * |--------------------------------------------------------------------------
         */

        $tag = Tag::whereRaw(
            'LOWER(name) = ?',
            [mb_strtolower($name)]
        )->first();

        /*
         * |--------------------------------------------------------------------------
         * | Create the tag if it does not exist
         * |--------------------------------------------------------------------------
         */

        if (!$tag) {
            $tag = Tag::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        return response()->json([
            'success' => true,
            'tag' => [
                'id' => $tag->id,
                'name' => $tag->name,
            ],
        ]);
    }
}
