<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert(array (
            0 =>
            array (
                'name' => 'admin',
                'guard_name' => 'web',
                'role_status'=> '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            1 =>
            array (
                'name' => 'lecturer',
                'guard_name' => 'web',
                'role_status'=> '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            2 =>
            array (
                'name' => 'student',
                'guard_name' => 'web',
                'role_status'=> '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
        ));
    }
}
