<?php

namespace App\Http\Controllers;

use App\Models\SocialPost;
use App\Models\Category;
use App\Http\Requests\StoreSocialPostRequest;
use App\Http\Requests\UpdateSocialPostRequest;
use Carbon\Carbon;

class SocialPostController extends Controller
{
    public function index()
    {
        // Eager load category to prevent N+1
        $posts = SocialPost::with('category')->latest('created_utc')->paginate(10);
        return view('social-posts.index', compact('posts'));
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

    public function destroy(SocialPost $socialPost)
    {
        $socialPost->delete();
        return redirect()->route('social-posts.index')->with('success', 'Post deleted permanently.');
    }
}
