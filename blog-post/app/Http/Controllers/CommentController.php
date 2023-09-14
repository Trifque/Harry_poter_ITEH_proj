<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class CommentController extends Controller
{
    /* GET-eri */
    /* SET-eri */
    /* POST-eri */

        public function createComment(Request $request)
        {
            $validatedData = $request->validate
            ([
                'user_id' => 'required|integer',
                'post_id' => 'required|integer',
                'text' => 'required|string',
            ]);

            $comment = Comment::create($validatedData);

            $post_owner = Post::where('post_id',$validatedData['post_id'])->pluck('user_id');
            $user = User::where('user_id',$post_owner)->first();
            $popularity = $user['popularity'];
            $popularity = $popularity + 2;
            $user->popularity = $popularity;
            $user->save();


            return response()->json(['message' => 'Comment created successfully', 'data' => $comment], 201);
        }

    /* DELETE-eri */
}
