<?php

namespace App\Http\Controllers;

use App\Models\Equipment;

use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function createEquipment(Request $request)
    { $validated = $request->validate([
            'name' => 'required|string|unique:equipment,name',
            'description' => 'nullable|string',
        ]);

        $category = new Equipment();
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

    public function readAllEquipments(){
        try
        {
            $categories = Equipment::all();
            return response()->json($categories);
        } catch (\Exception $exception) {
            return response()->json([
                'error'=>'Failed to fetch Equipments.',
                'message'=>$exception->getMessage()
            ], 500);
        }
    }
        public function readEquipment($id){
        try
        {
            $category = Equipment::findOrFail($id);
            return response()->json($category);
        } catch (\Exception $exception) {
            return response()->json([
                'error'=>'Failed to fetch the Equipment.',
                'message'=>$exception->getMessage()
            ], 500);
        }
    }
    public function updateEquipment(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|unique:equipment,name,'.$id,
            'description' => 'nullable|string',
        ]);

        try
        {
            $category = Equipment::findOrFail($id);
            $category->name = $validated['name'];
            $category->description = $validated['description'];
            $category->save();
            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update category', 'error' => $e->getMessage()], 500);
        }
    }
       
    public function deleteEquipment($id){
        try{
            $category = Equipment::findOrFail($id);
            $category->delete();
            return response()->json(['message' => 'Equipment deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete the Equipment.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}