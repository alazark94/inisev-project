<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Website;
use App\Notifications\NewPostNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Website $website)
    {
        // Validate
        $validated = $request->validate([
            'title' => ['required', 'min:15'],
            'body' => ['required', 'min:50']
        ]);

        // Create
        $post = $website->posts()->create($validated);

        // Notify
        $users = $website->users;

        Notification::send($users, new NewPostNotification($post));

        // Response

        return response()->json([
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'body' => $post->body
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json([
            'data' => [
                'post' => $post
            ]
        ]);
    }
}
