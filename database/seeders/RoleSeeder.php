<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'role_status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'lecturer',
                'guard_name' => 'web',
                'role_status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'student',
                'guard_name' => 'web',
                'role_status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'faculty admin',
                'guard_name' => 'web',
                'role_status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
