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
        Schema::create('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->autoIncrement();
            $table->string('course_code', 20)->unique();
            $table->string('course_title', 255);
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->timestamps();

            $table->primary('course_id');
            $table->index('course_code');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
