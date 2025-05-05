<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create a new table with the desired structure
        Schema::create('books_new', function (Blueprint $table) {
            $table->string('book_id', 20)->primary();
            $table->string('B_title');
            $table->string('B_Author');
            $table->string('language');
            $table->string('AddBy');
            $table->date('DateAdd');
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });

        // Copy data from the old table to the new one
        $books = DB::table('books')->get();
        foreach ($books as $book) {
            DB::table('books_new')->insert([
                'book_id' => $book->book_id,
                'B_title' => $book->B_title,
                'B_Author' => $book->B_Author,
                'language' => $book->language,
                'AddBy' => $book->AddBy,
                'DateAdd' => $book->DateAdd,
                'views' => $book->views,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at,
            ]);
        }

        // Drop the old table
        Schema::dropIfExists('books');

        // Rename the new table to the original name
        Schema::rename('books_new', 'books');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Create the original table structure
        Schema::create('books_original', function (Blueprint $table) {
            $table->id('B_ID');
            $table->string('book_id', 20);
            $table->string('B_title');
            $table->string('B_Author');
            $table->string('language');
            $table->string('AddBy');
            $table->date('DateAdd');
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });

        // Copy data back
        $books = DB::table('books')->get();
        $id = 1;
        foreach ($books as $book) {
            DB::table('books_original')->insert([
                'B_ID' => $id++,
                'book_id' => $book->book_id,
                'B_title' => $book->B_title,
                'B_Author' => $book->B_Author,
                'language' => $book->language,
                'AddBy' => $book->AddBy,
                'DateAdd' => $book->DateAdd,
                'views' => $book->views,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at,
            ]);
        }

        // Drop the current table
        Schema::dropIfExists('books');

        // Rename the original structure table
        Schema::rename('books_original', 'books');
    }
};
