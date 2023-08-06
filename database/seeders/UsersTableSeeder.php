<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Josep Bacardit',
                'email' => 'josep@example.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$oNVOXBH77EzJ9BbLqgPYmu6.5rLI.RUFbm63nCLpiRNxopXN6DSza',
                'remember_token' => NULL,
                'created_at' => '2023-08-06 15:56:03',
                'updated_at' => '2023-08-06 16:09:27',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Núria Coma',
                'email' => 'nuria@example.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$iGX1xSmo8OMVbZlgGJQAM.lkCdp9sJ6Xv1n.uWfoDoo74fn98HNMi',
                'remember_token' => NULL,
                'created_at' => '2023-08-06 15:57:39',
                'updated_at' => '2023-08-06 15:57:39',
            ),
        ));


    }
}
