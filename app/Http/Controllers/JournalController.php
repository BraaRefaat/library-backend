<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JournalController
{
    /**
     * Display a listing of the journals.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journals = Journal::all();
        return response()->json(['data' => $journals], 200);
    }

    /**
     * Store a newly created journal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'D_title' => 'required|string|max:255',
            'D_Author' => 'required|string|max:255',
            'type' => 'required|in:ماجستير,دكتوراة',
            'copies' => 'required|integer|min:1',
            'AddBy' => 'required|string|max:255',
            'DateAdd' => 'required|date',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'D_number' => 'required|string|max:255',
            'D_notes' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,C_ID'
        ], [
            'D_title.required' => 'عنوان الرسالة مطلوب',
            'D_title.string' => 'عنوان الرسالة يجب أن يكون نصاً',
            'D_title.max' => 'عنوان الرسالة يجب أن لا يتجاوز 255 حرف',
            'D_Author.required' => 'اسم المؤلف مطلوب',
            'D_Author.string' => 'اسم المؤلف يجب أن يكون نصاً',
            'D_Author.max' => 'اسم المؤلف يجب أن لا يتجاوز 255 حرف',
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
            'D_number.required' => 'رقم الرسالة مطلوب',
            'D_number.string' => 'رقم الرسالة يجب أن يكون نصاً',
            'D_number.max' => 'رقم الرسالة يجب أن لا يتجاوز 255 حرف',
            'D_notes.string' => 'الملاحظات يجب أن تكون نصاً',
            'department_id.exists' => 'القسم المحدد غير موجود'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $journal = Journal::create($request->all());
        return response()->json($journal, 201);
    }

    /**
     * Display the specified journal.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $journal = Journal::find($id);

        if (!$journal) {
            return response()->json(['message' => 'الدورية غير موجودة'], 404);
        }

        return response()->json(['data' => $journal], 200);
    }

    /**
     * Update the specified journal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $journal = Journal::find($id);

        if (!$journal) {
            return response()->json(['error' => 'الرسالة غير موجودة'], 404);
        }

        $validator = Validator::make($request->all(), [
            'D_title' => 'sometimes|string|max:255',
            'D_Author' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:ماجستير,دكتوراة',
            'copies' => 'sometimes|integer|min:1',
            'AddBy' => 'sometimes|string|max:255',
            'DateAdd' => 'sometimes|date',
            'year' => 'sometimes|integer|min:1900|max:' . date('Y'),
            'D_number' => 'sometimes|string|max:255',
            'D_notes' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,C_ID'
        ], [
            'D_title.string' => 'عنوان الرسالة يجب أن يكون نصاً',
            'D_title.max' => 'عنوان الرسالة يجب أن لا يتجاوز 255 حرف',
            'D_Author.string' => 'اسم المؤلف يجب أن يكون نصاً',
            'D_Author.max' => 'اسم المؤلف يجب أن لا يتجاوز 255 حرف',
            'type.in' => 'نوع الرسالة يجب أن يكون إما ماجستير أو دكتوراة',
            'copies.integer' => 'عدد النسخ يجب أن يكون رقماً صحيحاً',
            'copies.min' => 'عدد النسخ يجب أن يكون 1 على الأقل',
            'AddBy.string' => 'اسم المضيف يجب أن يكون نصاً',
            'AddBy.max' => 'اسم المضيف يجب أن لا يتجاوز 255 حرف',
            'DateAdd.date' => 'تاريخ الإضافة غير صالح',
            'year.integer' => 'السنة يجب أن تكون رقماً صحيحاً',
            'year.min' => 'السنة يجب أن تكون 1900 أو أحدث',
            'year.max' => 'السنة يجب أن لا تتجاوز السنة الحالية',
            'D_number.string' => 'رقم الرسالة يجب أن يكون نصاً',
            'D_number.max' => 'رقم الرسالة يجب أن لا يتجاوز 255 حرف',
            'D_notes.string' => 'الملاحظات يجب أن تكون نصاً',
            'department_id.exists' => 'القسم المحدد غير موجود'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $journal->update($request->all());
        return response()->json($journal);
    }

    /**
     * Remove the specified journal from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $journal = Journal::find($id);

        if (!$journal) {
            return response()->json(['message' => 'الدورية غير موجودة'], 404);
        }

        $journal->delete();

        return response()->json(['message' => 'تم حذف الدورية بنجاح'], 200);
    }

    /**
     * Search for journals by title, author, or magazine name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->get('query');

        if (!$query) {
            return response()->json(['message' => 'استعلام البحث مطلوب'], 422);
        }

        $journals = Journal::where('D_title', 'like', "%{$query}%")
            ->orWhere('D_Author', 'like', "%{$query}%")
            ->orWhere('name_magazine', 'like', "%{$query}%")
            ->get();

        return response()->json(['data' => $journals], 200);
    }

    /**
     * Filter journals by year.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterByYear(Request $request)
    {
        $year = $request->get('year');

        if (!$year) {
            return response()->json(['message' => 'يجب إدخال السنة'], 422);
        }

        $journals = Journal::where('year', $year)->get();

        return response()->json(['data' => $journals], 200);
    }
}
