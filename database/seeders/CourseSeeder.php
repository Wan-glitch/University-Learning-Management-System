<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'name' => 'Intro to Programming',
            'description' => 'A basic course in programming.',
            'faculty' => 1, // Assuming the team ID is 1 for Computer Science Department
            'pic' => 1, // Assuming the user ID 1 is the person in charge
            'created_by' => 1,
            'updated_by' => 1,
            'status' => 1,
            'year' => 2024,
            'term' => 1
        ]);

        Course::create([
            'name' => 'Advanced Calculus',
            'description' => 'An advanced course in calculus.',
            'faculty' => 2, // Assuming the team ID is 2 for Mathematics Department
            'pic' => 2, // Assuming the user ID 2 is the person in charge
            'created_by' => 1,
            'updated_by' => 1,
            'status' => 1,
            'year' => 2024,
            'term' => 2
        ]);
    }
}
