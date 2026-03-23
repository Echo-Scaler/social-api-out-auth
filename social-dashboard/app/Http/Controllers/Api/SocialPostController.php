<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SocialPost;
use App\Http\Requests\StoreSocialPostRequest;
use App\Http\Requests\UpdateSocialPostRequest;
use App\Http\Resources\SocialPostResource;

class SocialPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = SocialPost::latest('created_utc')->paginate(15);
        
        return SocialPostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocialPostRequest $request)
    {
        $post = SocialPost::create($request->validated());
        
        return new SocialPostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialPost $socialPost)
    {
        return new SocialPostResource($socialPost);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocialPostRequest $request, SocialPost $socialPost)
    {
        $socialPost->update($request->validated());
        
        return new SocialPostResource($socialPost);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialPost $socialPost)
    {
        $socialPost->delete();
        
        return response()->json(null, 204);
    }
}
