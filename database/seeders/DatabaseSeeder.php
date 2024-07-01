<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\FacultySeeder;
use Database\Seeders\UsersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(RoleSeeder::class);
        $this->call(FacultySeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(CourseScheduleSeeder::class);
        $this->call(CourseUserTableSeeder::class);
        $this->call(ModelHasRole::class);
        $this->call(PermParentSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RoleHasPermissionsSeeder::class);

    }
}
