<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->unsignedBigInteger('assignment_id')->autoIncrement();
            $table->string('title', 255);
            $table->date('due_date');
            $table->time('due_time');
            $table->text('description');
            $table->string('file_path')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('course_id');

            $table->foreign('course_id')
                  ->references('course_id')
                  ->on('courses')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
