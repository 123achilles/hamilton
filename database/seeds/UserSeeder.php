<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Api',
                'email' => 'adminadmin@mail.ru',
                'password' => Hash::make('adminadmin11'), // secret
                'remember_token' => md5(rand()),
                'role' => ConstUserRole::ADMIN,
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('user11'), // secret
                'remember_token' => md5(rand()),
                'role' => ConstUserRole::USER,
            ],
        ]);
    }
}
