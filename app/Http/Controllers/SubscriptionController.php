<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function createSubscription(Request $request)
    { $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'bundle_id' => 'required|integer|exists:bundles,id',
        ]);

        $subscription = new Subscription();
        $subscription->user_id = $validated['user_id'];
        $subscription->bundle_id = $validated['bundle_id'];
        
        try
        {
            $subscription->save();
            return response()->json($subscription);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create subscription', 'error' => $e->getMessage()], 500);
        }      
    }


    public function readAllSubscriptions(){
        try
        {
            $subscriptions = Subscription::all();
            return response()->json($subscriptions);
        } catch (\Exception $exception) {
            return response()->json([
                'error'=>'Failed to fetch Subscriptions.',
                'message'=>$exception->getMessage()
            ], 500);
        }
    }
    public function readSubscription($id){
        try
        {
            $subscription = Subscription::findOrFail($id);
            return response()->json($subscription);
        } catch (\Exception $exception) {
            return response()->json([
                'error'=>'Failed to fetch the Subscription.',
                'message'=>$exception->getMessage()
            ], 500);
        }
    }
    public function updateSubscription(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|unique:subscriptions,name,'.$id,
            'description' => 'nullable|string',
        ]);

        try
        {
            $subscription = Subscription::findOrFail($id);
            $subscription->name = $validated['name'];
            $subscription->description = $validated['description'];
            $subscription->save();
            return response()->json($subscription);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update subscription', 'error' => $e->getMessage()], 500);
        }
    }
       
    public function deleteSubscription($id){
        try{
            $subscription = Subscription::findOrFail($id);
            $subscription->delete();
            return response()->json(['message' => 'Subscription deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete the Subscription.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
