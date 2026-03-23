<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RedditApiService;
use App\Services\SocialPostService;
use Exception;

class SyncSocialPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'social:sync {subreddit=webdev} {--limit=25}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize social posts from a specific subreddit';

    /**
     * Execute the console command.
     */
    public function handle(RedditApiService $redditApiService, SocialPostService $socialPostService)
    {
        $subreddit = $this->argument('subreddit');
        $limit = (int) $this->option('limit');

        $this->info("Starting sync for r/{$subreddit}...");

        try {
            $posts = $redditApiService->getSubredditPosts($subreddit, $limit);
            
            if ($posts->isEmpty()) {
                $this->warn("No posts found for r/{$subreddit}.");
                return 0;
            }

            $socialPostService->syncPosts($posts->toArray(), $subreddit);
            
            $this->success("Successfully synced " . $posts->count() . " posts from r/{$subreddit}!");
        } catch (Exception $e) {
            $this->error("Sync failed: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Custom success message helper.
     */
    protected function success($message)
    {
        $this->output->writeln("<info>✔</info> {$message}");
    }
}
