<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * Get all departments
     */
    public function index()
    {
        $departments = Department::all();
        return response()->json($departments);
    }

    /**
     * Get a specific department
     */
    public function show($id)
    {
        $department = Department::find($id);
        
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }
        
        return response()->json($department);
    }

    /**
     * Get messages for a specific department
     */
    public function getMessages($id)
    {
        $department = Department::find($id);
        
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }
        
        $messages = Message::where('department_id', $id)->get();
        
        return response()->json([
            'department' => $department,
            'messages' => $messages
        ]);
    }

    /**
     * Store a new department
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'C_name' => 'required|string|max:255|unique:departments'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $department = Department::create($request->all());
        
        return response()->json($department, 201);
    }

    /**
     * Update a department
     */
    public function update(Request $request, $id)
    {
        $department = Department::find($id);
        
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'C_name' => 'required|string|max:255|unique:departments,C_name,' . $id . ',C_ID'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $department->update($request->all());
        
        return response()->json($department);
    }

    /**
     * Delete a department
     */
    public function destroy($id)
    {
        $department = Department::find($id);
        
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }
        
        $department->delete();
        
        return response()->json(['message' => 'Department deleted successfully']);
    }
}
