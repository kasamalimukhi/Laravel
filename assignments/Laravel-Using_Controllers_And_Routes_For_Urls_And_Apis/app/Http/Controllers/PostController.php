<?php

// namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
// use App\Models\Post;
// use Illuminate\Http\Request;

// class PostController extends Controller
// {
//     //
//     public function index()
//     {
//         return Post::paginate(10);
//     }
//     public function createPost(Request $request)
//     {
//         $data = $request->validate([
//             'title' => ['required', 'string','min:6'],
//             'content' => ['required' , 'string','max:2000'],
//             'user_id' => ['required','exists:users,id']
//         ]);

//         return Post::create($data);
//     }
// }

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::paginate(10), 200);
    }

    public function createPost(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => ['required', 'string', 'min:6'],
                'content' => ['required', 'string', 'max:2000'],
                'user_id' => ['required', 'exists:users,id']
            ]);

            $post = Post::create($data);

            return response()->json($post, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
