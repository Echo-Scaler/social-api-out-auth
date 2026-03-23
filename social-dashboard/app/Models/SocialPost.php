<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    protected $fillable = [
        'category_id',
        'subreddit',
        'post_id',
        'title',
        'author',
        'url',
        'permalink',
        'score',
        'num_comments',
        'created_utc',
        'thumbnail',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
