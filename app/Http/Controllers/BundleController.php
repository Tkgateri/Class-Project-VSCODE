<?php

namespace App\Http\Controllers;

use App\Models\Bundle;

use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function createBundle(Request $request)
    { $validated = $request->validate([
            'name' => 'required|string|unique:bundles,name',
            'start_time' => 'required',
            'duration' => 'required',
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $bundle = new Bundle();
        $bundle->name = $validated['name'];
        $bundle->start_time = $validated['start_time'];
        $bundle->duration = $validated['duration'];
        $bundle->category_id = $validated['category_id'];
        $bundle->description = $validated['description'];
        
        try
        {
            $bundle->save();
            return response()->json($bundle);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create bundle', 'error' => $e->getMessage()], 500);
        }
    }
    public function readAllBundles(){
        try{
            // $bundles = Bundle::all();
            $bundles = Bundle::join('categories', 'bundles.category_id', '=', 'categories.id')
            ->select('bundles.*', 'categories.name as category_name');
            return response()->json($bundles);
        } 
        catch (\Exception $exception) {
            return response()->json([
                'error'=>'Failed to fetch Bundles.',    
                'message'=>$exception->getMessage()]
            );;
        }}
    public function readBundle($id){
        try{
            $bundle = Bundle::findOrFail($id);
            return response()->json($bundle);
        } catch (\Exception $exception) {
            return response()->json([
                'error'=>'Failed to fetch the Bundles.',
                'message'=>$exception->getMessage()]
            );
        }
    }
    public function updateBundle(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|unique:bundles,name,'.$id,
            'description' => 'nullable|string',
        ]);

        try
        {
            $bundle = Bundle::findOrFail($id);
            $bundle->name = $validated['name'];
            $bundle->description = $validated['description'];
            $bundle->save();
            return response()->json($bundle);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update bundle', 'error' => $e->getMessage()], 500);
        }
    }   
    public function deleteBundle($id){
        try{
            $bundle = Bundle::findOrFail($id);
            $bundle->delete();
            return response()->json(['message' => 'Bundle deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete the Bundle.',
                'message' => $e->getMessage()
            ], 500  );
        }
    }
}