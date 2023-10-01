<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();

        DB::table('permissions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'create_user',
                'guard_name' => 'api',
                'created_at' => '2023-08-06 14:51:57',
                'updated_at' => '2023-08-06 15:58:34',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'edit_user',
                'guard_name' => 'api',
                'created_at' => '2023-08-06 14:53:13',
                'updated_at' => '2023-08-06 14:53:13',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'delete_user',
                'guard_name' => 'api',
                'created_at' => '2023-08-06 14:53:13',
                'updated_at' => '2023-08-06 14:53:13',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'show_user',
                'guard_name' => 'api',
                'created_at' => '2023-08-06 14:53:13',
                'updated_at' => '2023-08-06 14:53:13',
            ),
        ));


    }
}
