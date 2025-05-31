<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController
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
            return response()->json(['error' => 'القسم غير موجود'], 404);
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
            return response()->json(['error' => 'القسم غير موجود'], 404);
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
        ], [
            'C_name.required' => 'اسم القسم مطلوب',
            'C_name.string' => 'اسم القسم يجب أن يكون نصاً',
            'C_name.max' => 'اسم القسم يجب أن لا يتجاوز 255 حرف',
            'C_name.unique' => 'هذا القسم موجود بالفعل'
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
            return response()->json(['error' => 'القسم غير موجود'], 404);
        }

        $validator = Validator::make($request->all(), [
            'C_name' => 'required|string|max:255|unique:departments,C_name,' . $id . ',C_ID'
        ], [
            'C_name.required' => 'اسم القسم مطلوب',
            'C_name.string' => 'اسم القسم يجب أن يكون نصاً',
            'C_name.max' => 'اسم القسم يجب أن لا يتجاوز 255 حرف',
            'C_name.unique' => 'هذا القسم موجود بالفعل'
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
            return response()->json(['error' => 'القسم غير موجود'], 404);
        }

        $department->delete();

        return response()->json(['message' => 'تم حذف القسم بنجاح']);
    }
}
