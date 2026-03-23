<?php

namespace App\Http\Controllers;

use App\Http\Requests\FetchSocialPostsRequest;
use App\Services\RedditApiService;
use App\Services\SocialPostService;
use App\Models\SocialPost;

class WebDashboardController extends Controller
{
    /**
     * Web controller for dashboard logic.
     * Uses Services to abstract the API calls and database synchronization.
     */
    public function index(
        FetchSocialPostsRequest $request, 
        RedditApiService $redditApiService, 
        SocialPostService $socialPostService
    ) {
        $subreddit = $request->getSubreddit();

        // 1. Fetch posts using the Cached API Service
        $posts = $redditApiService->getSubredditPosts($subreddit, 20);

        // 2. Delegate persistence to the Service Layer
        $socialPostService->syncPosts($posts->toArray(), $subreddit);

        // 3. Delegate metric calculation to the Service Layer
        $metrics = $socialPostService->getMetricsForSubreddit($subreddit);

        // 4. Paginate posts for the view
        $dbPosts = SocialPost::where('subreddit', $subreddit)
            ->orderBy('created_utc', 'desc')
            ->paginate(5);
            
        $dbPosts->appends(['subreddit' => $subreddit]);

        return view('simple-dashboard', [
            'metrics'           => $metrics,
            'posts'             => $dbPosts,
            'current_subreddit' => $subreddit
        ]);
    }
}
