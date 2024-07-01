<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $course1 = Course::where('name', 'Intro to Programming')->first();
        $course2 = Course::where('name', 'Advanced Calculus')->first();

        $user1 = User::where('email', 'zura@gmail.com')->first();
        $user2 = User::where('email', 'devzon3@gmail.com')->first();

        // Check if the courses and users exist
        if (!$course1) {
            $this->command->error('Course "Intro to Programming" not found.');
        } elseif (!$course2) {
            $this->command->error('Course "Advanced Calculus" not found.');
        } elseif (!$user1) {
            $this->command->error('User "zura@gmail.com" not found.');
        } elseif (!$user2) {
            $this->command->error('User "devzon3@gmail.com" not found.');
        } else {
            // Assign users to courses
            $course1->users()->attach($user1->id); // User "zura@gmail.com" -> Course "Intro to Programming"
            $course2->users()->attach($user2->id); // User "devzon3@gmail.com" -> Course "Advanced Calculus"
        }
    }
}
