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
        // Add a new string ID column
        Schema::table('books', function (Blueprint $table) {
            $table->string('book_id', 20)->after('B_ID')->nullable();
        });

        // Generate complex IDs for existing books
        $books = DB::table('books')->get();
        foreach ($books as $book) {
            $newId = 'BK' . str_pad($book->B_ID, 6, '0', STR_PAD_LEFT) . substr(uniqid(), -4);
            DB::table('books')
                ->where('B_ID', $book->B_ID)
                ->update(['book_id' => $newId]);
        }

        // Make the new column required
        Schema::table('books', function (Blueprint $table) {
            $table->string('book_id', 20)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('book_id');
        });
    }
};
