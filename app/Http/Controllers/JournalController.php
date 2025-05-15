<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JournalController extends Controller
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
            'AddBy' => 'required|string|max:255',
            'Num_magazine' => 'required|string|max:255',
            'name_magazine' => 'required|string|max:255',
            'Magazine_folder' => 'required|string|max:255',
            'year' => 'required|integer',
            'D_number' => 'required|string|max:255',
            'D_notes' => 'nullable|string',
            'DateAdd' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $journal = Journal::create($request->all());
        
        return response()->json(['message' => 'Journal created successfully', 'data' => $journal], 201);
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
            return response()->json(['message' => 'Journal not found'], 404);
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
            return response()->json(['message' => 'Journal not found'], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'D_title' => 'sometimes|required|string|max:255',
            'D_Author' => 'sometimes|required|string|max:255',
            'AddBy' => 'sometimes|required|string|max:255',
            'Num_magazine' => 'sometimes|required|string|max:255',
            'name_magazine' => 'sometimes|required|string|max:255',
            'Magazine_folder' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer',
            'D_number' => 'sometimes|required|string|max:255',
            'D_notes' => 'nullable|string',
            'DateAdd' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $journal->update($request->all());
        
        return response()->json(['message' => 'Journal updated successfully', 'data' => $journal], 200);
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
            return response()->json(['message' => 'Journal not found'], 404);
        }
        
        $journal->delete();
        
        return response()->json(['message' => 'Journal deleted successfully'], 200);
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
            return response()->json(['message' => 'Search query is required'], 422);
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
            return response()->json(['message' => 'Year parameter is required'], 422);
        }
        
        $journals = Journal::where('year', $year)->get();
        
        return response()->json(['data' => $journals], 200);
    }
}
