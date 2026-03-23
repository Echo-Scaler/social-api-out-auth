<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class RedditApiService
{
    /**
     * Fetch posts from a public subreddit.
     * Uses caching to prevent hitting rate limits.
     *
     * @param string $subreddit
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getSubredditPosts(string $subreddit = 'webdev', int $limit = 10)
    {
        $cacheKey = "reddit_posts_{$subreddit}_{$limit}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($subreddit, $limit) {
            $response = Http::withHeaders([
                'User-Agent' => 'SocialMediaDashboard/1.0 (Laravel)',
            ])->get("https://www.reddit.com/r/{$subreddit}/hot.json", [
                'limit' => $limit,
            ]);

            if ($response->successful()) {
                $posts = $response->json('data.children');
                
                return collect($posts)->map(function ($post) {
                    $data = $post['data'];
                    return [
                        'id' => $data['id'],
                        'title' => $data['title'],
                        'author' => $data['author'],
                        'url' => $data['url'],
                        'permalink' => "https://reddit.com" . $data['permalink'],
                        'score' => $data['score'], // likes/upvotes
                        'num_comments' => $data['num_comments'],
                        'created_utc' => $data['created_utc'],
                        'thumbnail' => $data['thumbnail'] ?? null,
                    ];
                });
            }

            return collect([]);
        });
    }
}
