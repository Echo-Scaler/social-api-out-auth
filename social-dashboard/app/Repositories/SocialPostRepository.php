<?php

namespace App\Repositories;

use App\Models\SocialPost;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SocialPostRepository
{
    /**
     * Create or update a social post.
     */
    public function updateOrCreate(array $attributes, array $values): SocialPost
    {
        return SocialPost::updateOrCreate($attributes, $values);
    }

    /**
     * Get paginated posts for a specific subreddit.
     */
    public function getPaginatedBySubreddit(string $subreddit, int $perPage = 5): LengthAwarePaginator
    {
        return SocialPost::where('subreddit', $subreddit)
            ->orderBy('created_utc', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get engagement metrics for a subreddit.
     */
    public function getMetrics(string $subreddit): array
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
