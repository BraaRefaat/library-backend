<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController
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
            return response()->json(['error' => 'القسم غير موجود'], 404);
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
            'type' => 'required|in:ماجستير,دكتوراة',
            'copies' => 'required|integer|min:1',
            'AddBy' => 'required|string|max:255',
            'DateAdd' => 'required|date',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'M_number' => 'required|string|max:255',
            'M_notes' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,C_ID'
        ], [
            'M_title.required' => 'عنوان الرسالة مطلوب',
            'M_title.string' => 'عنوان الرسالة يجب أن يكون نصاً',
            'M_title.max' => 'عنوان الرسالة يجب أن لا يتجاوز 255 حرف',
            'M_Author.required' => 'اسم المؤلف مطلوب',
            'M_Author.string' => 'اسم المؤلف يجب أن يكون نصاً',
            'M_Author.max' => 'اسم المؤلف يجب أن لا يتجاوز 255 حرف',
            'type.required' => 'نوع الرسالة مطلوب',
            'type.in' => 'نوع الرسالة يجب أن يكون إما ماجستير أو دكتوراة',
            'copies.required' => 'عدد النسخ مطلوب',
            'copies.integer' => 'عدد النسخ يجب أن يكون رقماً صحيحاً',
            'copies.min' => 'عدد النسخ يجب أن يكون 1 على الأقل',
            'AddBy.required' => 'اسم المضيف مطلوب',
            'AddBy.string' => 'اسم المضيف يجب أن يكون نصاً',
            'AddBy.max' => 'اسم المضيف يجب أن لا يتجاوز 255 حرف',
            'DateAdd.required' => 'تاريخ الإضافة مطلوب',
            'DateAdd.date' => 'تاريخ الإضافة غير صالح',
            'year.required' => 'السنة مطلوبة',
            'year.integer' => 'السنة يجب أن تكون رقماً صحيحاً',
            'year.min' => 'السنة يجب أن تكون 1900 أو أحدث',
            'year.max' => 'السنة يجب أن لا تتجاوز السنة الحالية',
            'M_number.required' => 'رقم الرسالة مطلوب',
            'M_number.string' => 'رقم الرسالة يجب أن يكون نصاً',
            'M_number.max' => 'رقم الرسالة يجب أن لا يتجاوز 255 حرف',
            'M_notes.string' => 'الملاحظات يجب أن تكون نصاً',
            'department_id.exists' => 'القسم المحدد غير موجود'
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
            return response()->json(['error' => 'الرسالة غير موجودة'], 404);
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
            return response()->json(['error' => 'الرسالة غير موجودة'], 404);
        }

        $validator = Validator::make($request->all(), [
            'M_title' => 'sometimes|string|max:255',
            'M_Author' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:ماجستير,دكتوراة',
            'copies' => 'sometimes|integer|min:1',
            'AddBy' => 'sometimes|string|max:255',
            'DateAdd' => 'sometimes|date',
            'year' => 'sometimes|integer|min:1900|max:' . date('Y'),
            'M_number' => 'sometimes|string|max:255',
            'M_notes' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,C_ID'
        ], [
            'M_title.string' => 'عنوان الرسالة يجب أن يكون نصاً',
            'M_title.max' => 'عنوان الرسالة يجب أن لا يتجاوز 255 حرف',
            'M_Author.string' => 'اسم المؤلف يجب أن يكون نصاً',
            'M_Author.max' => 'اسم المؤلف يجب أن لا يتجاوز 255 حرف',
            'type.in' => 'نوع الرسالة يجب أن يكون إما ماجستير أو دكتوراة',
            'copies.integer' => 'عدد النسخ يجب أن يكون رقماً صحيحاً',
            'copies.min' => 'عدد النسخ يجب أن يكون 1 على الأقل',
            'AddBy.string' => 'اسم المضيف يجب أن يكون نصاً',
            'AddBy.max' => 'اسم المضيف يجب أن لا يتجاوز 255 حرف',
            'DateAdd.date' => 'تاريخ الإضافة غير صالح',
            'year.integer' => 'السنة يجب أن تكون رقماً صحيحاً',
            'year.min' => 'السنة يجب أن تكون 1900 أو أحدث',
            'year.max' => 'السنة يجب أن لا تتجاوز السنة الحالية',
            'M_number.string' => 'رقم الرسالة يجب أن يكون نصاً',
            'M_number.max' => 'رقم الرسالة يجب أن لا يتجاوز 255 حرف',
            'M_notes.string' => 'الملاحظات يجب أن تكون نصاً',
            'department_id.exists' => 'القسم المحدد غير موجود'
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
            return response()->json(['error' => 'الرسالة غير موجودة'], 404);
        }

        $message->delete();

        return response()->json(['message' => 'تم حذف الرسالة بنجاح']);
    }
}
