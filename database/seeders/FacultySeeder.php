<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // // Example: Get a valid user ID for `pic`, `created_by`, and `updated_by`
        // $userId = DB::table('users')->inRandomOrder()->value('id');

        // Insert sample data into faculties table
        DB::table('faculties')->insert([
            [
                'title' => 'Faculty of Science',
                'description' => 'This is the Faculty of Science.',

                'status' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Faculty of Arts',
                'description' => 'This is the Faculty of Arts.',

                'status' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Faculty of Engineering',
                'description' => 'This is the Faculty of Engineering.',

                'status' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
