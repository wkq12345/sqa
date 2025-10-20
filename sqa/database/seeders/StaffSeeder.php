<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('staffs')->insert([
            [
                'name' => 'staff',
                'identification_number' => null,
                'photo' => null,
                'staff_id' => 'ST0001',
                'user_id' => 1,
                'role_id' => 1
            ],
        ]);
    }
}
