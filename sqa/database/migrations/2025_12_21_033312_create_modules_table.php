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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();

            // Foreign key to students table
            $table->foreignId('student_id')
                  ->constrained('students')
                  ->onDelete('cascade');

            // Store student name (snapshot from students table)
            $table->string('name');

            // Foreign key to courses table
            $table->foreignId('course_id')
                  ->constrained('courses', 'course_id')
                  ->onDelete('cascade');

            // Enrollment status
            $table->enum('status', ['active', 'completed', 'withdrawn'])
                  ->default('active');

            $table->timestamps();

            // Indexes for performance
            $table->index('student_id');
            $table->index('course_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
