<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModelHasRole extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('model_has_roles')->delete();

        DB::table('model_has_roles')->insert(array (
            0 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\Models\User',
                'model_id' => 2,
            ),
            1 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\Models\User',
                'model_id' => 3,
            ),
            2 =>
            array (
                'role_id' => 3,
                'model_type' => 'App\Models\User',
                'model_id' => 1,
            ),
        ));
    }
}
