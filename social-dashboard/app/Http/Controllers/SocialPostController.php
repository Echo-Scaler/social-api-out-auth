<?php

namespace App\Http\Controllers;

use App\Models\SocialPost;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SocialPostController extends Controller
{
    public function index()
    {
        $posts = SocialPost::latest('created_utc')->paginate(10);
        return view('social-posts.index', compact('posts'));
    }

    public function create()
    {
        return view('social-posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subreddit' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:100',
            'url' => 'nullable|url',
        ]);

        $validated['post_id'] = 'custom_' . uniqid();
        $validated['permalink'] = '/custom/' . $validated['post_id'];
        $validated['created_utc'] = Carbon::now();
        $validated['score'] = 0;
        $validated['num_comments'] = 0;

        SocialPost::create($validated);

        return redirect()->route('social-posts.index')->with('success', 'Custom Post created successfully!');
    }

    public function edit(SocialPost $socialPost)
    {
        return view('social-posts.edit', compact('socialPost'));
    }

    public function update(Request $request, SocialPost $socialPost)
    {
        $validated = $request->validate([
            'subreddit' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'score' => 'required|integer|min:0',
        ]);

        $socialPost->update($validated);

        return redirect()->route('social-posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(SocialPost $socialPost)
    {
        $socialPost->delete();
        return redirect()->route('social-posts.index')->with('success', 'Post deleted permanently.');
    }
}
