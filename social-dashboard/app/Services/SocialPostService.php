<?php

namespace App\Services;

use App\Models\SocialPost;
use Carbon\Carbon;
use Illuminate\Support\Collection;

use App\Repositories\SocialPostRepository;
use Illuminate\Support\Facades\Log;

class SocialPostService
{
    protected $repository;

    public function __construct(SocialPostRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Synchronize posts from an external list into the local database.
     */
    public function syncPosts(array $posts, string $subreddit, ?int $categoryId = null): void
    {
        Log::info("Starting batch sync for r/{$subreddit}", ['count' => count($posts)]);

        try {
            foreach ($posts as $postData) {
                $this->repository->updateOrCreate(
                    ['post_id' => $postData['id']],
                    [
                        'category_id'  => $categoryId,
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
            Log::info("Successfully synced posts for r/{$subreddit}");
        } catch (\Exception $e) {
            Log::error("Failed to sync posts for r/{$subreddit}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Compute and return metric aggregates using the repository.
     */
    public function getMetricsForSubreddit(string $subreddit): array
    {
        return $this->repository->getMetrics($subreddit);
    }
}
