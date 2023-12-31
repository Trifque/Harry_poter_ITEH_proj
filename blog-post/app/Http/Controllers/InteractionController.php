<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    /* GET-eri */
    /* SET-eri */
    /* POST-eri */

        public function makeInteraction(Request $request)
        {
            $validatedData = $request->validate
            ([
                'user_id' => 'required|integer',
                'post_id' => 'required|integer',
                'type' => 'required|string',
            ]);

            $oldInteraction = Interaction::where('user_id',$validatedData['user_id'])->where('post_id',$validatedData['post_id'])->get();

            $post_owner = Post::where('post_id',$validatedData['post_id'])->pluck('user_id');
            $user = User::where('user_id',$post_owner)->first();
            $popularity = $user['popularity'];

            $interaction = null;
            $alreadyThere = false;
            $editedWhatIsAlreadyThere = false;
            foreach ($oldInteraction as $oneOldInteraction) {
                switch ($validatedData['type']) {
                    case 'like':
                    {   
                        switch ($oneOldInteraction['type']) 
                        {
                            case 'like':
                                {   
                                    $oneOldInteraction->delete();
                                    $alreadyThere = true;
                                     break;
                                }
                            case 'dislike':
                                {
                                    $oneOldInteraction->update($validatedData);
                                    $editedWhatIsAlreadyThere = true;
                                    $alreadyThere = true;
                                    $popularity = $popularity + 2;
                                    break;
                                }
                            case 'save':
                                {
                                    break;
                                }
                        }
                        break;
                    }
                    case 'dislike':
                    {
                        switch ($oneOldInteraction['type']) 
                        {
                            case 'like':
                                {
                                    $oneOldInteraction->update($validatedData);
                                    $editedWhatIsAlreadyThere = true;
                                    $alreadyThere = true;
                                    $popularity = $popularity - 2;
                                    break;
                                }
                            case 'dislike':
                                {
                                    $oneOldInteraction->delete();
                                    $alreadyThere = true;
                                    break;
                                }
                            case 'save':
                                {
                                    break;
                                }
                        }
                        break;
                    }
                    case 'save':
                    {
                        switch ($oneOldInteraction['type']) 
                        {
                            case 'like':
                                {
                                    break;
                                }
                            case 'dislike':
                                {
                                    break;
                                }
                            case 'save':
                                {
                                    $oneOldInteraction->delete();
                                    $alreadyThere = true;
                                    break;
                                }
                        }
                        break;
                    }

                    if ($editedWhatIsAlreadyThere || $alreadyThere || $interaction != null) 
                    {
                        break;
                    }
                }

            }

            if($alreadyThere == false)
            {
                if($validatedData['type'] == 'like')
                {
                    $popularity = $popularity + 1;
                    $user->popularity = $popularity;
                    $user->save();
                } else if($validatedData['type'] == 'dislike')
                {
                    $popularity = $popularity - 1;
                    $user->popularity = $popularity;
                    $user->save();
                }
                $interaction = Interaction::create($validatedData);
                return response()->json(['message' => 'Interaction has been made successfully', 'data' => $interaction], 201);
            } else if($alreadyThere && $editedWhatIsAlreadyThere)
            {
                $user->popularity = $popularity;
                $user->save();
                return response()->json(['message' => 'Interaction has been edited successfully'], 201);
            } else
            {
                return response()->json(['message' => 'Your interaction has been unmade successfully'], 201);
            }
        }
}