<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /* SVE ZA KATEGORIJE */

    /* GET-eri */

        public function getAllCategories()
        {
            $categories = Category::all();
            
            if(is_null($categories)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($categories);
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
        Category::where('category_id', $validatedData['category_id'])->delete();

        return response()->json(['message' => 'Category Deleted successfully'], 201);
    }

}
