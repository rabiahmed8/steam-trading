<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function store(Request $request)
    {

        $user_id = Auth::id();

        // $title = '[H]' . ' ' . $request->have . ' ' . '[W]' . ' ' . $request->want;

        Post::create([
            'user_id' => $user_id,
            'buying' => $request->want,
            'selling' => $request->have,
            // 'content' => '[Q] What do you need?'
        ]);
        return redirect()->back();
    }

    public function find()
    {
        // $posts = Post::all();
        // Log::info("kuch bhi");
        // $skins = Skin::all();
        $posts = Post::with('user')->latest()->get();
        return view('dashboard', compact('posts'));
    }
}
