<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookViewsSeeder extends Seeder
{
    /**
     * Seed the book views.
     */
    public function run(): void
    {
        // Get all books
        $books = Book::all();

        // Set different view counts for each book
        foreach ($books as $index => $book) {
            // Create different view counts to test ordering
            $viewCount = $index * 5 + rand(1, 10);
            $book->views = $viewCount;
            $book->save();

            $this->command->info("Set {$viewCount} views for book: {$book->B_title}");
        }

        $this->command->info('Book views have been seeded successfully!');
    }
}
