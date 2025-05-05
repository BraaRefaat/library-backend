<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'name' => 'George R.R. Martin',
                'biography' => 'American novelist and short story writer, best known for A Song of Ice and Fire.',
                'birth_date' => '1948-09-20',
                'nationality' => 'American',
            ],
            [
                'name' => 'J.K. Rowling',
                'biography' => 'British author, best known for writing the Harry Potter fantasy series.',
                'birth_date' => '1965-07-31',
                'nationality' => 'British',
            ],
            [
                'name' => 'Stephen King',
                'biography' => 'American author of horror, supernatural fiction, suspense, and fantasy novels.',
                'birth_date' => '1947-09-21',
                'nationality' => 'American',
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
