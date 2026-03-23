<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subreddit' => $this->subreddit,
            'post_id' => $this->post_id,
            'title' => $this->title,
            'author' => $this->author,
            'metrics' => [
                'score' => $this->score,
                'comments' => $this->num_comments,
            ],
            'links' => [
                'url' => $this->url,
                'permalink' => $this->permalink,
                'thumbnail' => $this->thumbnail,
            ],
            'created_utc' => $this->created_utc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
