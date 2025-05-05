<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id('M_ID');
            $table->string('M_title');
            $table->string('M_Author');
            $table->enum('type', ['master', 'phd']);
            $table->integer('copies');
            $table->string('AddBy');
            $table->date('DateAdd');
            $table->string('M_number');
            $table->text('M_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
