<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentTableSeeder extends Seeder
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

            DB::table('comments')->insert([
                'user_id' => $faker->randomNumber(2, true),
                'body' => $faker->paragraph,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
