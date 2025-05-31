<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if the authenticated user is an administrator
        if (Auth::user()->role !== 'مسؤول') {
            return response()->json(['message' => 'غير مصرح به'], 403);
        }

        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Update a user's role by ID.
     */
    public function updateRole(Request $request, $id)
    {
        // Check if the authenticated user is an administrator
        if (Auth::user()->role !== 'مسؤول') {
            return response()->json(['message' => 'غير مصرح به'], 403);
        }

        // Validate the request
        $request->validate([
            'role' => 'required|string|in:مسؤول,موظف,طالب',
        ]);

        // Find the user to update
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'المستخدم غير موجود'], 404);
        }

        // Prevent administrator from changing their own role via this endpoint
        if ($user->id === Auth::id()) {
             return response()->json(['message' => 'لا يمكنك تغيير دورك الخاص عبر نقطة النهاية هذه'], 400);
        }

        // Update the user's role
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'message' => 'تم تحديث دور المستخدم بنجاح',
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check if the authenticated user is an administrator
        if (Auth::user()->role !== 'مسؤول') {
            return response()->json(['message' => 'غير مصرح به'], 403);
        }

        // Find the user to delete
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'المستخدم غير موجود'], 404);
        }

         // Prevent administrator from deleting themselves via this endpoint
        if ($user->id === Auth::id()) {
             return response()->json(['message' => 'لا يمكنك حذف نفسك عبر نقطة النهاية هذه'], 400);
        }

        // Delete the user
        $user->delete();

        return response()->json(['message' => 'تم حذف المستخدم بنجاح']);
    }
}
