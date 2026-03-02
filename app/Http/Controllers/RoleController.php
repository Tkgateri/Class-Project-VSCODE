<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Role::class, 'role');
    }



    //CRUD FUNCTIONS
    //CREATE
    public function createRole(Request $request)
    { $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'description' => 'nullable|string',
        ]);

        $role = new Role();
        $role->name = $validated['name'];
        $role->description = $validated['description'];
        
        try
        {
            $role->save();
            return response()->json($role);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create role', 'error' => $e->getMessage()], 500);
        }

        
    }
    
    //READ ALL ROLES
    public function readAllRoles(){
        try
        {
            $roles = Role::all();
            return response()->json($roles);
        } catch (\Exception $exception) {
            return response()->json([
                'error'=>'Failed to fetch Roles.',
                'message'=>$exception->getMessage()
            ]   );
        }
    }

    //READ ONE ROLE
    public function readRole($id){
        try
        {
            $role = Role::findOrFail($id);
            return response()->json($role);
        } catch (\Exception $exception) {
            return response()->json([
                'error'=>'Failed to fetch the Role.',
                'message'=>$exception->getMessage()
            ], 500  );
        }
    }
    //UPDATE
    public function updateRole(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,'.$id,
            'description' => 'nullable|string',
        ]);

        try
        {
            $role = Role::findOrFail($id);
            $role->name = $validated['name'];
            $role->description = $validated['description'];
            $role->save();
            return response()->json($role);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update role', 'error' => $e->getMessage()], 500);
        }
    }
    
    //DELETE
    public function deleteRole($id){
        try{
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json(['message' => 'Role deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete the Role.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}