<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            "name"=>"Rabi Ahmed",
            "email"=>"ahmedrabi8@gmail.com",
            "username"=>"ahmedrabi8",
            "password"=>bcrypt("asdfasdf")
            // 'remember_token'=>
            // 'email_verified_at'=>
    ]);
    }
}
