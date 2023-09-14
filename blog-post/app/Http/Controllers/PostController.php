<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Awarded_to;
use App\Models\Interaction;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /* SVE ZA POST */

    /* GET-eri */

        public function getPostsMadeByUser($user_id)
        {
            $posts = Post::where('user_id', $user_id)->get();
            $posts = PostController::getPostData($posts,$user_id);
            
            if(is_null($posts)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($posts);
        }

        public function getPostsLikedByUser($user_id)
        {
            $likedPosts = Interaction::where('user_id',$user_id)->where('type','like')->get('post_id');
            $posts = $likedPosts->map(function ($likedPost)
            {
                $post = Post::where('post_id',$likedPost['post_id'])->first();
                return $post;
            });

            $posts = PostController::getPostData($posts,$user_id);
            
            if(is_null($posts)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($posts);
        }

        public function getPostsSavedByUser($user_id)
        {
            $savedPosts = Interaction::where('user_id',$user_id)->where('type','save')->get('post_id');
            $posts = $savedPosts->map(function ($savedPost)
            {
                $post = Post::where('post_id',$savedPost['post_id'])->first();
                return $post;
            });

            $posts = PostController::getPostData($posts,$user_id);
            
            if(is_null($posts)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($posts);
        }

        public function getPostsCommentedByUser($user_id)
        {
            $commentedPosts = Comment::where('user_id',$user_id)->get('post_id');
            $commentedPosts = $commentedPosts->unique();
            $posts = $commentedPosts->map(function ($commentedPost)
            {
                $post = Post::where('post_id',$commentedPost['post_id'])->first();
                return $post;
            });

            $posts = PostController::getPostData($posts,$user_id);
            
            if(is_null($posts)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($posts);
        }

        //public function getForYouPage($user_id)
        //{
        //    $oneWeekAgo = Carbon::now()->subWeek();
        //    $posts = Interaction::where('date', '>=', $oneWeekAgo)->orderBy('date', 'DESC')->get();
        //    $posts = Post::getPostData($posts,$user_id);
        //}

        public function getNewPosts($user_id)
        {
            $oneWeekAgo = Carbon::now()->subWeek();
            $posts = Post::where('date', '>=', $oneWeekAgo)->orderBy('date', 'DESC')->get();
            $posts = PostController::getPostData($posts,$user_id);
            
            if(is_null($posts)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($posts);
        }

        public function getPostsByCategory($category, $user_id)
        {
            $category_id = Category::where('category_name', $category)->pluck('category_id');
            $posts = Post::where('category_id', $category_id)->get();
            $posts = PostController::getPostData($posts,$user_id);
            
            if(is_null($posts)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($posts);
        }

    /* POST-eri */

        public function createPost(Request $request)
        {
            $validatedData = $request->validate
            ([
                'user_id' => 'required|integer',
                'category_id' => 'required|integer',
                'title' => 'required|string',
                'content' => 'required|string',
            ]);
            $validatedData['date'] = date('Y-m-d');
            $validatedData['time'] = date('H:i:s');

            $post = Post::create($validatedData);

            return response()->json(['message' => 'Post created successfully', 'data' => $post], 201);
        }
    
    /* PUT-eri */
    
        public function editPost(Request $request)
        {
            $validatedData = $request->validate
            ([
                'post_id' => 'required|integer',
                'category_id' => 'required|integer',
                'title' => 'required|string',
                'content' => 'required|string',
            ]);

            $post = Post::where('post_id',$validatedData['post_id'])->first();
            $post->update($validatedData);

            return response()->json(['message' => 'Post edited successfully', 'data' => $post], 201);
        }

    /* DELETE-eri */
        
        public function deletePost(Request $request)
        {
            $validatedData = $request->validate(['post_id' => 'required|integer']);
            Post::where('post_id', $validatedData['post_id'])->delete();

            return response()->json(['message' => 'Post Deleted successfully'], 201);
        }
    
    /* Pomocna funkcija koja se ponavlja/koristi svugde za postove */

    public function getPostData($posts, $user_id)
    {
        $posts = $posts->map(function ($post) use($user_id) 
        {

            $post['id'] = $post['post_id'];
            $post_category = Category::where('category_id',$post['category_id'])->get('category_name');
            $post['category'] = $post_category[0]['category_name'];
            $post_creator = User::where('user_id',$post['user_id'])->get(['house','first_name','last_name','username']);
            $post['house'] = $post_creator[0]['house'];
            $post['user'] = $post_creator[0]['first_name'] . ' ' . $post_creator[0]['last_name'] . ' (' . $post_creator[0]['username'] . ')';

            $likes = 0;
            $dislikes = 0;
            $user_like = false;
            $user_dislike = false;
            $user_saved = false;
            $interactions = Interaction::where('post_id', $post['id'])->get();
            $interactions->each(function ($interaction) use(&$likes ,&$dislikes ,&$user_like ,&$user_dislike ,&$user_saved ,$user_id ) 
            {
                if($interaction['type'] == 'like')
                    {
                        if($interaction['user_id'] == $user_id)
                            {
                                $user_like = true;
                            }
                        $likes++;
                    }
                else if($interaction['type'] == 'dislike')
                    {
                        if($interaction['user_id'] == $user_id)
                            {
                                $user_dislike = true;
                            }
                        $dislikes++;
                    }
                if($interaction['type'] == 'save' && $interaction['user_id'] == $user_id)
                    {
                        $user_saved = true;
                    }
            });

            $post['likes'] = $likes;
            $post['dislikes'] = $dislikes;
            $post['liked'] = $user_like;
            $post['disliked'] = $user_dislike;
            $post['saved'] = $user_saved;

            $comments = Comment::where('post_id', $post['id'])->get();
            $comments = $comments->map(function ($comment)
            {
                $comment_creator = User::where('user_id',$comment['user_id'])->get(['first_name','last_name','username']);
                $comment['user'] = $comment_creator[0]['first_name'] . ' ' . $comment_creator[0]['last_name'] . ' (' . $comment_creator[0]['username'] . ')';
                return $comment;
            });
            $post['comments'] = $comments;

            $award_ids = Award::all()->pluck('award_id');
            $all_awards_to_this_post = Awarded_to::where('post_id', $post['id'])->get();
            $total_number_of_awards_on_post = 0;
            $award_counts = [];
            foreach ($award_ids as $current_award_id) {
                $current_award_amount = $all_awards_to_this_post->where('award_id', $current_award_id)->count();
                $total_number_of_awards_on_post = $total_number_of_awards_on_post + $current_award_amount;
                $award_data = Award::where('award_id',$current_award_id)->get(['award_type','award_name','description']);
                $award_counts[] = ['id' => $current_award_id, 'award_type' => $award_data[0]['award_type'], 'name' => $award_data[0]['award_name'], 'description' => $award_data[0]['description'], 'amount' => $current_award_amount];
            }
            $post['awards'] = $award_counts;

            $post['popularity'] = 0 + $likes -$dislikes + (2 * sizeof($comments)) + (10 * $total_number_of_awards_on_post);

            unset($post['post_id']);
            unset($post['category_id']);
            return $post;
        });
        return $posts;
    }
        

        
}
