<?php

namespace Database\Seeders;

use App\Models\Chat;
use Illuminate\Database\Seeder;


class ChatsTableSeeder extends Seeder
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
