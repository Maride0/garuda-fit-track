<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$pdaOH1mjcir3jTIJvqe.3etJHuFsFJHaJJgJ7aqqwygyE/Ro/.dVO',
                'role' => 'admin',
                'remember_token' => NULL,
                'created_at' => '2025-12-08 11:09:41',
                'updated_at' => '2025-12-08 11:09:41',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Mari',
                'email' => 'maryamfatimah4@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$xLdeiQ62uGHVMpLMNqm5x.XknCdMO1ysCO3SkCLH7BGMLO1qegs6m',
                'role' => 'supervisor',
                'remember_token' => NULL,
                'created_at' => '2025-12-13 03:42:27',
                'updated_at' => '2025-12-13 03:42:27',
            ),
        ));
        
        
    }
}