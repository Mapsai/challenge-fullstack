<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $faker = Factory::create();
            $date = date('Y-m-d H:i:s');

            $email = $faker->email;

            DB::table('users')->insert([
                'name' => $faker->firstName . ' ' . $faker->lastName,
                'email' => $email,
                'password' => Hash::make($email),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
