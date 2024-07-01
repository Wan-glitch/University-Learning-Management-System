<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the permissions data using raw SQL queries
        $permissions = [
            [
                'name' => 'Create User',
                'perm_parent' => '1',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Read User',
                'perm_parent' => '1',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Update User',
                'perm_parent' => '1',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Delete User',
                'perm_parent' => '1',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Create Role',
                'perm_parent' => '2',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Read Role',
                'perm_parent' => '2',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Update Role',
                'perm_parent' => '2',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Assign Role',
                'perm_parent' => '2',
                'guard_name'  => 'web',
            ],

            [
                'name' => 'Create Bulletin',
                'perm_parent' => '3',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Read Bulletin',
                'perm_parent' => '3',
                'guard_name'  => 'web',
            ],

            [
                'name' => 'Update Bulletin',
                'perm_parent' => '3',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Delete Bulletin',
                'perm_parent' => '3',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Create Course',
                'perm_parent' => '4',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Read Course',
                'perm_parent' => '4',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Update Course',
                'perm_parent' => '4',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Delete Course',
                'perm_parent' => '4',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Create Faculty',
                'perm_parent' => '5',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Read Faculty',
                'perm_parent' => '5',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Update Faculty',
                'perm_parent' => '5',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Delete Faculty',
                'perm_parent' => '5',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Create slideshow',
                'perm_parent' => '6',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Read slideshow',
                'perm_parent' => '6',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Update slideshow',
                'perm_parent' => '6',
                'guard_name'  => 'web',
            ],
            [
                'name' => 'Update Delete',
                'perm_parent' => '6',
                'guard_name'  => 'web',
            ],


        ];

        // Insert the data into the permissions table using raw SQL queries
        DB::table('permissions')->insert($permissions);
    }
}
