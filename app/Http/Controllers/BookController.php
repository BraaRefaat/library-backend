<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController
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
            return response()->json(['message' => 'الكتاب غير موجود'], 404);
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
            'language' => 'required|string|in:English,عربي',
            'AddBy' => 'required|string|max:255',
            'DateAdd' => 'required|date',
            'image' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0',
        ], [
            'B_title.required' => 'عنوان الكتاب مطلوب',
            'B_title.max' => 'عنوان الكتاب يجب أن لا يتجاوز 255 حرف',
            'B_Author.required' => 'اسم المؤلف مطلوب',
            'B_Author.max' => 'اسم المؤلف يجب أن لا يتجاوز 255 حرف',
            'language.required' => 'اللغة مطلوبة',
            'language.in' => 'اللغة يجب أن تكون إما English أو عربي',
            'AddBy.required' => 'اسم المضيف مطلوب',
            'AddBy.max' => 'اسم المضيف يجب أن لا يتجاوز 255 حرف',
            'DateAdd.required' => 'تاريخ الإضافة مطلوب',
            'DateAdd.date' => 'تاريخ الإضافة غير صالح',
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.mimes' => 'نوع الصورة يجب أن يكون webp, jpeg, png, jpg, أو gif',
            'image.max' => 'حجم الصورة يجب أن لا يتجاوز 2 ميجابايت',
            'stock.required' => 'الكمية المتوفرة مطلوبة',
            'stock.integer' => 'الكمية المتوفرة يجب أن تكون رقماً صحيحاً',
            'stock.min' => 'الكمية المتوفرة يجب أن تكون 0 أو أكثر',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $validated['image'] = $imagePath;
        }

        $book = Book::create($validated);
        return response()->json($book, 201);
    }

    /**
     * Update an existing book
     */
    public function update(Request $request, $id)
    {
        // Use where for string primary key
        $book = Book::where('book_id', $id)->first();

        if (!$book) {
            return response()->json(['message' => 'الكتاب غير موجود'], 404);
        }

        // Remove image if requested
        if ($request->has('remove_image') && $request->boolean('remove_image')) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
                $book->image = null;
                $book->save(); // Persist the change
            }
        }

        $validated = $request->validate([
            'B_title' => 'string|max:255',
            'B_Author' => 'string|max:255',
            'language' => 'string|in:English,عربي',
            'AddBy' => 'string|max:255',
            'DateAdd' => 'date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'stock' => 'integer|min:0',
        ], [
            'B_title.max' => 'عنوان الكتاب يجب أن لا يتجاوز 255 حرف',
            'B_Author.max' => 'اسم المؤلف يجب أن لا يتجاوز 255 حرف',
            'language.in' => 'اللغة يجب أن تكون إما English أو عربي',
            'AddBy.max' => 'اسم المضيف يجب أن لا يتجاوز 255 حرف',
            'DateAdd.date' => 'تاريخ الإضافة غير صالح',
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.mimes' => 'نوع الصورة يجب أن يكون webp, jpeg, png, jpg, أو gif',
            'image.max' => 'حجم الصورة يجب أن لا يتجاوز 2 ميجابايت',
            'stock.integer' => 'الكمية المتوفرة يجب أن تكون رقماً صحيحاً',
            'stock.min' => 'الكمية المتوفرة يجب أن تكون 0 أو أكثر',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $validated['image'] = $imagePath;
        }

        $book->update($validated);
        $book->refresh(); // Ensure latest data
        return response()->json($book);
    }

    /**
     * Delete a book
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'الكتاب غير موجود'], 404);
        }

        $book->delete();
        return response()->json(['message' => 'تم حذف الكتاب بنجاح']);
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
                'message' => 'لا يوجد كتب قد تم مشاهدتها بعد',
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

        if (!in_array($language, ['عربي', 'English'])) {
            return response()->json(['message' => 'هذه اللغة غير صالحة'], 400);
        }

        $books = Book::where('language', $language)->get();
        return response()->json($books);
    }
}
