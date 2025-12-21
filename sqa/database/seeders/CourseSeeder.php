<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseCourses = [
            ['Software Quality Assurance', 'Software Engineering'],
            ['Software Evolution and Maintenance', 'Software Engineering'],
            ['Database Systems', 'Data Management'],
            ['Operating Systems', 'Computer Systems'],
            ['Web Application Development', 'Web Development'],
            ['Mobile Application Development', 'Application Development'],
            ['Artificial Intelligence', 'Artificial Intelligence'],
            ['Machine Learning', 'Artificial Intelligence'],
            ['Computer Networks', 'Networking'],
            ['Cyber Security', 'Security'],
            ['Data Structures and Algorithms', 'Computer Science'],
            ['Object Oriented Programming', 'Programming'],
            ['Discrete Mathematics', 'Mathematics'],
            ['Applied Statistics', 'Mathematics'],
            ['Cloud Computing', 'Cloud Technology'],
            ['Internet of Things', 'Embedded Systems'],
            ['Human Computer Interaction', 'User Experience'],
            ['Software Testing', 'Software Engineering'],
            ['Game Development', 'Multimedia'],
            ['Virtual Reality', 'Multimedia'],
        ];

        $counter = 1;

        for ($i = 1; $i <= 100; $i++) {

            $base = $baseCourses[array_rand($baseCourses)];

            $courseCode = 'BCS' . str_pad(2000 + $i, 4, '0', STR_PAD_LEFT);

            Course::updateOrCreate(
                ['course_code' => $courseCode],
                [
                    'course_title' => $base[0] . ' ' . $i,
                    'description'  => 'This course covers fundamental and advanced concepts related to ' . strtolower($base[0]) . '.',
                    'category'     => $base[1],
                ]
            );

            $counter++;
        }
    }
}
