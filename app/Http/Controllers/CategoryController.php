<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
     public function createCategory(Request $request)
    { $validated = $request->validate([
            'name' => 'required|string|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        $category = new Category()
        $category->name = $validated['name'];
        $category->description = $validated['description'];
        
        try
        {
            $category->save();
            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create category', 'error' => $e->getMessage()], 500);
        }

        
    }
}
    public function readAllCategories()[
        try
        {
            $categories = Category::all();
            return response()->json($categories);
        } catch (\Exception $exception) {
            return response()->json([
                'error'=>'Failed to fetch Categories.'
                'message'=>$exception->getMessage()
            ));
        }
    
        public function readCategory($id){
        try
        {
            $category = Category::findOrFail($id);
            return response()->json($category);
        } catch (\Exception $exception) {
            return response()->json([
                'error'=>'Failed to fetch the Category.'
                'message'=>$exception->getMessage()
            ));
        }
    }
    public function updateCategory(Request $request, id){
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name,'.$id,
            'description' => 'nullable|string',
        ]);

        try
        {
            $category = Category::findOrFail($id);
            $category->name = $validated['name'];
            $category->description = $validated['description'];
            $category->save();
            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update category', 'error' => $e->getMessage()], 500);
        }
    }
       
    public function deleteCategory($id){
        try{
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete the Category.',
                'message' => $e->getMessage()
            ], );
        }
    }
}
