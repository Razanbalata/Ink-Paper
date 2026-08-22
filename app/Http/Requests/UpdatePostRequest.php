<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $post = $this->route('post');

        return [
            'title' => [
                'required',
                'string',
                'min:5',
                'max:255',
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts', 'slug')->ignore($post),
            ],
            'excerpt' => [
                'nullable',
                'string',
                'max:500',
            ],
            'content' => [
                'required',
                'string',
                'min:20',
            ],
            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],
            'status' => [
                'required',
                Rule::in([
                    'draft',
                    'published',
                    'archived',
                ]),
            ],
            'tags' => [
                'nullable',
                'array',
            ],
            'tags.*' => [
                'integer',
                'exists:tags,id',
            ],
            'published_at' => [
                'nullable',
                'date',
            ],
        ];
    }
}
