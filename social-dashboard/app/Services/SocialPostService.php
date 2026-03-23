<?php

namespace App\Services;

use App\Models\SocialPost;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SocialPostService
{
    /**
     * Store or update fetched posts into the database.
     *
     * @param Collection|array $posts
     * @param string $subreddit
     * @return void
     */
    public function syncPosts($posts, string $subreddit): void
    {
        foreach ($posts as $postData) {
            SocialPost::updateOrCreate(
                ['post_id' => $postData['id']],
                [
                    'subreddit'    => $subreddit,
                    'title'        => $postData['title'],
                    'author'       => $postData['author'],
                    'url'          => $postData['url'],
                    'permalink'    => $postData['permalink'],
                    'score'        => $postData['score'],
                    'num_comments' => $postData['num_comments'],
                    'created_utc'  => Carbon::createFromTimestamp($postData['created_utc']),
                    'thumbnail'    => $postData['thumbnail'],
                ]
            );
        }
    }

    /**
     * Compute and return metric aggregates for a specific subreddit.
     *
     * @param string $subreddit
     * @return array
     */
    public function getMetricsForSubreddit(string $subreddit): array
    {
        $query = SocialPost::where('subreddit', $subreddit);

        $totalLikes    = (int) $query->sum('score');
        $totalComments = (int) $query->sum('num_comments');
        $totalPosts    = $query->count();
        $avgEngagement = $totalPosts > 0 ? ($totalLikes + $totalComments) / $totalPosts : 0.0;

        return [
            'total_likes'    => $totalLikes,
            'total_comments' => $totalComments,
            'avg_engagement' => round($avgEngagement, 2),
            'total_posts'    => $totalPosts,
        ];
    }
}
