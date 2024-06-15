<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasAccess('platform.posts.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'post.title' => ['required', 'string', 'max:255'],
            'post.body' => ['required', 'string'],
            'post.post_tags' => ['required', 'array'],
            'post.preview_image' => ['required', 'integer'],
            'post.visibility' => ['required', 'boolean'],
        ];
    }
}
