<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id('D_ID');
            $table->string('D_title');
            $table->string('D_Author');
            $table->string('AddBy');
            $table->string('Num_magazine');
            $table->string('name_magazine');
            $table->string('Magazine_folder');
            $table->integer('year');
            $table->string('D_number');
            $table->text('D_notes')->nullable();
            $table->date('DateAdd');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodicals');
    }
};
