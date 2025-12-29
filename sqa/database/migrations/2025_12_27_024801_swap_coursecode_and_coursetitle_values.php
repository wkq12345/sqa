<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Swap `coursecode` and `coursetitle` values for all rows.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            $courses = DB::table('courses')->select('course_id','course_code','course_title')->get();
            foreach ($courses as $c) {
                DB::table('courses')->where('course_id', $c->course_id)->update([
                    'course_code' => $c->course_title,
                    'course_title' => $c->course_code,
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     * Run the swap again to restore original values.
     *
     * @return void
     */
    public function down()
    {
        DB::transaction(function () {
            $courses = DB::table('courses')->select('course_id','course_code','course_title')->get();
            foreach ($courses as $c) {
                DB::table('courses')->where('course_id', $c->course_id)->update([
                    'course_code' => $c->course_title,
                    'course_title' => $c->course_code,
                ]);
            }
        });
    }
};
