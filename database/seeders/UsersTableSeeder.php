<?php

namespace Database\Seeders;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->truncate(); //for cleaning earlier data to avoid duplicate entries
        // DB::table('users')->insert([
        //     'role' => 0,
        //     'user_name' => 'Naim Hariz',
        //     'email' => 'anaimhariz@gmail.com',
        //     'password' => Hash::make('password'),
        //     'user_address' => 'JKDM Presint 2',
        //     'user_postcode' => '62000',
        //     'user_state' => 'Putrajaya',
        // ]);

        $data = [
            [
                //'role' => 0,
                'name' => 'Irfan',
                'role' => 2,
                'phone_no' => '2123456789',
                'email' => 'lecturer@gmail.com',
                'password' => Hash::make('password'),
                'user_status' => 1,
                'faculty'=> 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                //'role' => 0,
                'name' => 'Mr Martin',
                'role' => 2,
                'phone_no' => '0125376789',
                'email' => 'lecturer1@gmail.com',
                'password' => Hash::make('password'),
                'user_status' => 1,
                'faculty'=> 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                //'role' => 0,
                'name' => 'Admin',
                'role' => 1,
                'phone_no' => '0123456789',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'user_status' => 1,
                'faculty'=> 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                //'role' => 1,
                'name' => 'Zura',
                'role' => 3,
                'phone_no' => '0123456788',
                'email' => 'student@gmail.com',
                'password' => Hash::make('password'),
                'user_status' => 1,
                'faculty'=> 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                //'role' => 1,
                'name' => 'Gabriel Chan',
                'role' => 3,
                'phone_no' => '0123126788',
                'email' => 'student1@gmail.com',
                'password' => Hash::make('password'),
                'user_status' => 1,
                'faculty'=> 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                //'role' => 1,
                'name' => 'Alex Chan',
                'role' => 3,
                'phone_no' => '0143126788',
                'email' => 'student2@gmail.com',
                'password' => Hash::make('password'),
                'user_status' => 1,
                'faculty'=> 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]

        ];

        \App\Models\User::insert($data);

    }
}
