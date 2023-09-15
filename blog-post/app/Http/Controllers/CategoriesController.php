<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Carbon;

class CategoriesController extends Controller
{
    /* SVE ZA KATEGORIJE */

    /* GET-eri */

        public static function getAllCategories()
        {
            $categories = Category::all();
            
            if(is_null($categories)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($categories);
        }


        public static function tagCloud()
        {
            $categories = Category::all();
            $oneWeekAgo = Carbon::now()->subWeek();
            $posts = Post::where('date', '>=', $oneWeekAgo)->orderBy('date', 'DESC')->get();

            $categoryCounts = $posts->groupBy('category_id')->map(function ($group) {
                return $group->count();
            });
    
            $result = [];
            foreach ($categories as $category) {
                $categoryId = $category->category_id;
                $categoryName = $category->category_name;
                $popularity = $categoryCounts->has($categoryId) ? $categoryCounts[$categoryId] : 0;
        
                $result[] = [
                    'category_id' => $categoryId,
                    'category_name' => $categoryName,
                    'popularity' => $popularity,
                ];
            }
        
            return $result;
        }
    /* POST-eri */

    public function createCategory(Request $request)
        {
            $validatedData = $request->validate
            ([
                'category_name' => 'required|string',
            ]);

            $category = Category::create($validatedData);

            return response()->json(['message' => 'Category created successfully', 'data' => $category], 201);
        }
    /* DELETE-eri */

    public function deleteCategory(Request $request)
    {
        $validatedData = $request->validate(['category_id' => 'required|integer']);
        Post::where('category_id', $validatedData['category_id'])->update(['category_id' => NULL]);
        Category::where('category_id', $validatedData['category_id'])->delete();

        return response()->json(['message' => 'Category Deleted successfully'], 201);
    }

}
