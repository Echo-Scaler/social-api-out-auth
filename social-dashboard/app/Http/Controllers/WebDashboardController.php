<?php

namespace App\Http\Controllers;

use App\Http\Requests\FetchSocialPostsRequest;
use App\Services\RedditApiService;
use App\Services\SocialPostService;
use App\Repositories\SocialPostRepository;

class WebDashboardController extends Controller
{
    /**
     * Web controller for dashboard logic.
     * Uses Services and Repositories to abstract logic and data access.
     */
    public function index(
        FetchSocialPostsRequest $request, 
        RedditApiService $redditApiService, 
        SocialPostService $socialPostService,
        SocialPostRepository $repository
    ) {
        $subreddit = $request->getSubreddit();

        // 1. Fetch posts using the Cached API Service
        $posts = $redditApiService->getSubredditPosts($subreddit, 20);

        // 2. Delegate persistence to the Service Layer
        $socialPostService->syncPosts($posts->toArray(), $subreddit);

        // 3. Delegate metric calculation to the Service Layer
        $metrics = $socialPostService->getMetricsForSubreddit($subreddit);

        // 4. Use the Repository for paginated data retrieval
        $dbPosts = $repository->getPaginatedBySubreddit($subreddit, 5);
            
        $dbPosts->appends(['subreddit' => $subreddit]);

        return view('dashboard', [
            'metrics'           => $metrics,
            'posts'             => $dbPosts,
            'current_subreddit' => $subreddit
        ]);
    }
}
