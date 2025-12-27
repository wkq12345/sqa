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
        Schema::table('courses', function (Blueprint $table) {
            $table->renameColumn('course_title', 'temp_title');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->renameColumn('course_code', 'course_title');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->renameColumn('temp_title', 'course_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->renameColumn('course_code', 'temp_title');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->renameColumn('course_title', 'course_code');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->renameColumn('temp_title', 'course_title');
        });
    }
};
