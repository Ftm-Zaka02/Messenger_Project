<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\messenger\Chat;


class ChatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=\Faker\Factory::create();
        for ($i = 0; $i <= 5; $i++) {
            Chat::create([
                'chat_name'=>$faker->userName,
                'chat_type'=>'pv',
            ]);
        }
    }
}
