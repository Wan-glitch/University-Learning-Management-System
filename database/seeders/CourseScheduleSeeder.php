<?php

namespace Database\Seeders;

use App\Models\CourseSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseSchedule::create([
            'course_id' => 1, // Assuming the course ID is 1 for Intro to Programming
            'day_of_week' => 'Monday',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'location' => 'Room 101'
        ]);

        CourseSchedule::create([
            'course_id' => 1, // Assuming the course ID is 1 for Intro to Programming
            'day_of_week' => 'Wednesday',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'location' => 'Room 101'
        ]);

        CourseSchedule::create([
            'course_id' => 2, // Assuming the course ID is 2 for Advanced Calculus
            'day_of_week' => 'Tuesday',
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'location' => 'Room 202'
        ]);
    }
}
