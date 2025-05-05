<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Get all books
     */
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    /**
     * Get a specific book by ID
     */
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Increment the views count
        $book->increment('views');

        return response()->json($book);
    }

    /**
     * Create a new book
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'B_title' => 'required|string|max:255',
            'B_Author' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'AddBy' => 'required|string|max:255',
            'DateAdd' => 'required|date',
        ]);

        $book = Book::create($validated);
        return response()->json($book, 201);
    }

    /**
     * Update an existing book
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validated = $request->validate([
            'B_title' => 'string|max:255',
            'B_Author' => 'string|max:255',
            'language' => 'string|max:255',
            'AddBy' => 'string|max:255',
            'DateAdd' => 'date',
        ]);

        $book->update($validated);
        return response()->json($book);
    }

    /**
     * Delete a book
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();
        return response()->json(['message' => 'Book deleted successfully']);
    }

    /**
     * Search books by title or author
     */
    public function search(Request $request)
    {
        $query = $request->get('query');

        $books = Book::where('B_title', 'like', "%{$query}%")
                     ->orWhere('B_Author', 'like', "%{$query}%")
                     ->get();

        return response()->json($books);
    }

    /**
     * Get most visited books
     */
    public function mostVisited()
    {
        $books = Book::where('views', '>', 0)
                     ->orderBy('views', 'desc')
                     ->take(10)
                     ->get();

        if ($books->isEmpty()) {
            return response()->json([
                'message' => 'No books have been viewed yet',
                'books' => []
            ]);
        }

        return response()->json($books);
    }

    /**
     * Filter books by language
     */
    public function filterByLanguage(Request $request)
    {
        $language = $request->get('language');

        if (!in_array($language, ['Arabic', 'English'])) {
            return response()->json(['message' => 'Invalid language'], 400);
        }

        $books = Book::where('language', $language)->get();
        return response()->json($books);
    }
}
