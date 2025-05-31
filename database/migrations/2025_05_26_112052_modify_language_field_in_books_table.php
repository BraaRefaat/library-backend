<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyLanguageFieldInBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First update any existing records to use valid values
        DB::table('books')
            ->whereNotIn('language', ['English', 'عربي'])
            ->update(['language' => 'English']); // Default to English for any invalid values

        Schema::table('books', function (Blueprint $table) {
            $table->enum('language', ['English', 'عربي'])->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('language')->change();
        });
    }
}
