<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostDetailResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return PostDetailResource::collection($posts->loadMissing(['writer:id,username', 'comments']));
    }

    public function show($id)
    {
        $post = Post::with('writer:id,username')->findOrFail($id);
        return new PostDetailResource($post);
    }

    public function show2($id)
    {
        $post = Post::findOrFail($id);
        return new PostDetailResource($post);
    }

    public function store(Request $request)
    {
       
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $fileName = '';
        $extension = '';
        if ($request->file) {
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            Storage::putFileAs('image', $request->file, $fileName.'.'.$extension);
        }
        
         $request['image'] = $fileName.'.'.$extension;
         $request['author'] = Auth::user()->id;
         $post = Post::create($request->all());
         return new PostDetailResource($post->loadMissing('writer:id,username'));
        // return response()->json('hadeh');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,username'));

    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}