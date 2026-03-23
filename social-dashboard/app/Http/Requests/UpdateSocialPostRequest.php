<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSocialPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // For updates, the unique post_id validation should ignore the current post ID
        return [
            'subreddit' => 'string|max:100',
            'post_id' => 'string|max:100|unique:social_posts,post_id,' . $this->route('social_post')->id,
            'title' => 'string|max:255',
            'author' => 'string|max:100',
            'url' => 'nullable|url',
            'permalink' => 'string',
            'score' => 'integer|min:0',
            'num_comments' => 'integer|min:0',
            'created_utc' => 'nullable|date',
            'thumbnail' => 'nullable|string',
        ];
    }
}
