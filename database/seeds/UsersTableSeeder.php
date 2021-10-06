<?php

use App\User;
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
        User::create([
            'name' => 'azqq banting',
            'email' => 'azqq@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('12345678'),
            'image' => 'null',
            'thumbnail' => 'null',

        ]);
    }
}
