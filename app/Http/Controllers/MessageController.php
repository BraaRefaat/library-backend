<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Get all messages
     */
    public function index()
    {
        $messages = Message::with('department')->get();
        return response()->json($messages);
    }

    /**
     * Get messages by department
     */
    public function getByDepartment($departmentId)
    {
        $department = Department::find($departmentId);
        
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }
        
        $messages = Message::where('department_id', $departmentId)->get();
        
        return response()->json([
            'department' => $department,
            'messages' => $messages
        ]);
    }

    /**
     * Store a new message
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'M_title' => 'required|string|max:255',
            'M_Author' => 'required|string|max:255',
            'type' => 'required|in:master,phd',
            'copies' => 'required|integer|min:1',
            'AddBy' => 'required|string|max:255',
            'DateAdd' => 'required|date',
            'M_number' => 'required|string|max:255',
            'M_notes' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,C_ID'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $message = Message::create($request->all());
        
        return response()->json($message, 201);
    }

    /**
     * Get a specific message
     */
    public function show($id)
    {
        $message = Message::with('department')->find($id);
        
        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }
        
        return response()->json($message);
    }

    /**
     * Update a message
     */
    public function update(Request $request, $id)
    {
        $message = Message::find($id);
        
        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'M_title' => 'sometimes|string|max:255',
            'M_Author' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:master,phd',
            'copies' => 'sometimes|integer|min:1',
            'AddBy' => 'sometimes|string|max:255',
            'DateAdd' => 'sometimes|date',
            'M_number' => 'sometimes|string|max:255',
            'M_notes' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,C_ID'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $message->update($request->all());
        
        return response()->json($message);
    }

    /**
     * Delete a message
     */
    public function destroy($id)
    {
        $message = Message::find($id);
        
        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }
        
        $message->delete();
        
        return response()->json(['message' => 'Message deleted successfully']);
    }
}
