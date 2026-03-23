<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    protected $fillable = [
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
}
