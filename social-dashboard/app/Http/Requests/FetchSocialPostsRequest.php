<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FetchSocialPostsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subreddit' => 'nullable|string|alpha_dash|max:50'
        ];
    }
    
    public function getSubreddit(): string
    {
        return $this->validated('subreddit') ?? 'webdev';
    }
}
