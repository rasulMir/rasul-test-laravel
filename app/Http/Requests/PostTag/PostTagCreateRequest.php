<?php

namespace App\Http\Requests\PostTag;

use Illuminate\Foundation\Http\FormRequest;

class PostTagCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'post_tag.name' => ['required', 'string', 'max:255'],
        ];
    }
}
