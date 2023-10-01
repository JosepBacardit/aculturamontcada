<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Admin',
                'guard_name' => 'api',
                'created_at' => '2023-08-06 11:01:36',
                'updated_at' => '2023-08-06 11:01:36',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Editor',
                'guard_name' => 'api',
                'created_at' => '2023-08-06 11:01:36',
                'updated_at' => '2023-08-06 11:01:36',
            ),
        ));


    }
}
