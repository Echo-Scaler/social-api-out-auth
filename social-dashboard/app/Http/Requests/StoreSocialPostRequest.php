<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocialPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'subreddit' => 'required|string|max:100',
            'post_id' => 'required|string|unique:social_posts,post_id|max:100',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:100',
            'url' => 'nullable|url',
            'permalink' => 'required|string',
            'score' => 'integer|min:0',
            'num_comments' => 'integer|min:0',
            'created_utc' => 'nullable|date',
            'thumbnail' => 'nullable|string',
        ];
    }
}
