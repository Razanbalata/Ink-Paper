<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'body' => [
                'required',
                'string',
                'min:2',
                'max:1000',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'body.required' => 'Please write a comment.',
            'body.min' => 'Your comment must be at least 2 characters.',
            'body.max' => 'Your comment cannot exceed 1000 characters.',
        ];
    }
}