<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_MY');

        for ($i = 1; $i <= 1000; $i++) {

            // Create user account for student
            $user = User::updateOrCreate(
                ['email' => 'student' . $i . '@learnsphere.edu'],
                [
                    'password' => Hash::make('password'),
                    'role_id'  => 2, // STUDENT role
                ]
            );

            Student::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $faker->name,
                    'identification_number' => $faker->unique()->numerify('######-##-####'),
                    'student_id' => 'CB' . str_pad(220000 + $i, 6, '0', STR_PAD_LEFT),
                    'gender' => $faker->randomElement(['Male', 'Female']),
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'photo' => null,
                    'role_id' => 2, // STUDENT role
                ]
            );
        }
    }
}
