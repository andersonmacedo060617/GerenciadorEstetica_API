<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();
        \App\Models\User::create(
            array(
                'name'=>$_ENV['USR_ADMIN_NAME'], 
                'email'=>$_ENV['USR_ADMIN_EMAIL'], 
                'email_verified_at'=>strtotime('01/01/2000 01:00:00'),
                'password' => bcrypt($_ENV['USR_ADMIN_SENHA'])
            )
        );
    }
}
