<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Course;
use App\Models\Student;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();

        if ($students->count() < 10) {
            $this->command->error('Not enough students to assign modules.');
            return;
        }

        $statuses = ['active', 'completed', 'withdrawn'];

        Course::all()->each(function ($course) use ($students, $statuses) {

            // Pick 10 unique random students for this course
            $selectedStudents = $students->random(10);

            foreach ($selectedStudents as $student) {

                Module::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'course_id'  => $course->course_id,
                    ],
                    [
                        'name'   => $student->name,
                        'status' => $statuses[array_rand($statuses)],
                    ]
                );
            }
        });
    }
}
