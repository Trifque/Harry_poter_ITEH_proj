<?php

namespace App\Http\Controllers;

use App\Models\Awarded_to;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class Awarded_toController extends Controller
{
    /* GET-eri */
    /* SET-eri */
    /* POST-eri */
    
        public function giveAward(Request $request)
        {
            $validatedData = $request->validate
            ([
                'award_id' => 'required|integer',
                'user_id' => 'required|integer',
                'post_id' => 'required|integer',
            ]);

            $oldAward = Awarded_to::where('user_id',$validatedData['user_id'])->where('post_id',$validatedData['post_id'])->where('award_id',$validatedData['award_id'])->first();

            if($oldAward == null)
            {
                $post_owner = Post::where('post_id',$validatedData['post_id'])->pluck('user_id');
                $user = User::where('user_id',$post_owner)->first();
                $popularity = $user['popularity'];
                $popularity = $popularity + 10;
                $user->popularity = $popularity;
                $user->save();

                $comment = Awarded_to::create($validatedData);
                return response()->json(['message' => 'Award given successfully', 'data' => $comment], 201);
            } else
            {
                return response()->json(['message' => 'Award was already given'], 201);
            }
        }
    /* DELETE-eri */
}
