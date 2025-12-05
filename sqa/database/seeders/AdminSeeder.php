<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'name' => 'admin',
                'identification_number' => null,
                'photo' => null,
                'admin_id' => 'AD0001',
                'user_id' => 1,
                'role_id' => 1
            ],
        ]);
    }
}
