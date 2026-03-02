<?php

namespace App\Http\Controllers;

use App\Models\Gym; 

use Illuminate\Http\Request;

class GymController extends Controller
{
    public function createGym(Request $request)
    { $validated = $request->validate([
            'name' => 'required|string|unique:gym,name',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
            'description' => 'string|max:1000',
        ]);

        $gym = new Gym();
        $gym->name = $validated['name'];        
        $gym->longitude = $validated['name'];
        $gym->latitude = $validated['latitude'];
        $gym->description = $validated['description'];
        
        try
        {
            $gym->save();
            return response()->json($gym);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create gym', 'error' => $e->getMessage()], 500);
        }      
    }


    public function readAllGyms(){
        try
        {
            $gyms = Gym::all();
            return response()->json($gyms);
        } catch (\Exception $exception) {
            return response()->json([
                'error'=>'Failed to fetch Gyms.',
                'message'=>$exception->getMessage()
            ], 500);
        }
    }
    public function readGym($id){
        try
        {
            $gym = Gym::findOrFail($id);
            return response()->json($gym);
        } catch (\Exception $exception) {
            return response()->json([
                'error'=>'Failed to fetch the Gym.',
                'message'=>$exception->getMessage()
            ], 500);
        }
    }
    public function updateGym(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|unique:gyms,name,'.$id,
            'description' => 'nullable|string',
        ]);

        try
        {
            $gym = Gym::findOrFail($id);
            $gym->name = $validated['name'];
            $gym->description = $validated['description'];
            $gym->save();
            return response()->json($gym);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update gym', 'error' => $e->getMessage()], 500);
        }
    }
       
    public function deleteGym($id){
        try{
            $gym = Gym::findOrFail($id);
            $gym->delete();
            return response()->json(['message' => 'Gym deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete the Gym.',
                'message' => $e->getMessage()
            ], );
        }
    }
}