<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RedditApiService;
use App\Models\SocialPost;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getMetrics(RedditApiService $redditService)
    {
        // 1. Fetch posts using the Cached API Service
        $posts = $redditService->getSubredditPosts('webdev', 20);

        // 2. Persist to cache/DB
        foreach ($posts as $postData) {
            SocialPost::updateOrCreate(
                ['post_id' => $postData['id']],
                [
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

        // 3. Aggregate metrics
        $dbPosts = SocialPost::orderBy('created_utc', 'desc')->take(20)->get();

        $totalLikes = $dbPosts->sum('score');
        $totalComments = $dbPosts->sum('num_comments');
        $avgEngagement = $dbPosts->count() > 0 ? ($totalLikes + $totalComments) / $dbPosts->count() : 0;

        return response()->json([
            'metrics' => [
                'total_likes' => $totalLikes,
                'total_comments' => $totalComments,
                'avg_engagement' => round($avgEngagement, 2),
                'total_posts' => $dbPosts->count(),
            ],
            'recent_posts' => $dbPosts
        ]);
    }
}
