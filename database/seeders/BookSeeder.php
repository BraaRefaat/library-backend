<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'B_title' => 'Clean Code',
                'B_Author' => 'Robert C. Martin',
                'language' => 'English',
                'AddBy' => 'admin',
                'DateAdd' => now(),
            ],
            [
                'B_title' => 'Design Patterns',
                'B_Author' => 'Erich Gamma',
                'language' => 'English',
                'AddBy' => 'admin',
                'DateAdd' => now(),
            ],
            [
                'B_title' => 'Introduction to Algorithms',
                'B_Author' => 'Thomas H. Cormen',
                'language' => 'English',
                'AddBy' => 'admin',
                'DateAdd' => now(),
            ],
            [
                'B_title' => 'Database Systems',
                'B_Author' => 'Ramez Elmasri',
                'language' => 'English',
                'AddBy' => 'admin',
                'DateAdd' => now(),
            ],
            [
                'B_title' => 'Computer Networks',
                'B_Author' => 'Andrew S. Tanenbaum',
                'language' => 'English',
                'AddBy' => 'admin',
                'DateAdd' => now(),
            ]
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
