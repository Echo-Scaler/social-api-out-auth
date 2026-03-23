<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RedditApiService;
use App\Models\SocialPost;
use Carbon\Carbon;

class WebDashboardController extends Controller
{
    public function index(Request $request, RedditApiService $redditService)
    {
        // Default to 'webdev' if no query is provided
        $subreddit = $request->query('subreddit', 'webdev');

        // 1. Fetch posts using the Cached API Service
        $posts = $redditService->getSubredditPosts($subreddit, 20);

        // 2. Persist to cache/DB
        foreach ($posts as $postData) {
            SocialPost::updateOrCreate(
                ['post_id' => $postData['id']],
                [
                    'subreddit' => $subreddit,
                    'title' => $postData['title'],
                    'author' => $postData['author'],
                    'url' => $postData['url'],
                    'permalink' => $postData['permalink'],
                    'score' => $postData['score'],
                    'num_comments' => $postData['num_comments'],
                    'created_utc' => Carbon::createFromTimestamp($postData['created_utc']),
                    'thumbnail' => $postData['thumbnail'],
                ]
            );
        }

        // 3. Aggregate global metrics from the database (Filtered by current subreddit)
        $query = SocialPost::where('subreddit', $subreddit);
        $totalLikes = $query->sum('score');
        $totalComments = $query->sum('num_comments');
        $totalPosts = $query->count();
        $avgEngagement = $totalPosts > 0 ? ($totalLikes + $totalComments) / $totalPosts : 0;

        // 4. Paginate posts for the view
        $dbPosts = SocialPost::where('subreddit', $subreddit)->orderBy('created_utc', 'desc')->paginate(5);
        $dbPosts->appends(['subreddit' => $subreddit]); // Retain pagination parameter

        return view('simple-dashboard', [
            'metrics' => [
                'total_likes' => $totalLikes,
                'total_comments' => $totalComments,
                'avg_engagement' => round($avgEngagement, 2),
                'total_posts' => $totalPosts,
            ],
            'posts' => $dbPosts,
            'current_subreddit' => $subreddit
        ]);
    }
}
