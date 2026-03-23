<?php

namespace App\Http\Controllers;

use App\Models\SocialPost;
use App\Models\Category;
use App\Http\Requests\StoreSocialPostRequest;
use App\Http\Requests\UpdateSocialPostRequest;
use Carbon\Carbon;

class SocialPostController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = SocialPost::with('category');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('subreddit', 'like', "%{$searchTerm}%")
                  ->orWhere('author', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->latest('created_utc')->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('social-posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('social-posts.create', compact('categories'));
    }

    public function store(StoreSocialPostRequest $request)
    {
        SocialPost::create($request->validated());
        return redirect()->route('social-posts.index')->with('success', 'Custom Post created successfully!');
    }

    public function edit(SocialPost $socialPost)
    {
        $categories = Category::all();
        return view('social-posts.edit', compact('socialPost', 'categories'));
    }

    public function update(UpdateSocialPostRequest $request, SocialPost $socialPost)
    {
        $socialPost->update($request->validated());
        return redirect()->route('social-posts.index')->with('success', 'Post updated successfully.');
    }

    public function show(SocialPost $socialPost)
    {
        return view('social-posts.show', compact('socialPost'));
    }

    public function destroy(SocialPost $socialPost)
    {
        $socialPost->delete();
        return redirect()->route('social-posts.index')->with('success', 'Post deleted permanently.');
    }
}
