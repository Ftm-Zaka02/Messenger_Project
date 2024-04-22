<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=\Faker\Factory::create();
        for ($i = 1; $i <= 5; $i++) {
            Message::create([
                'text_message'=>$faker->realText($maxNbChars = 50),
                'send_time'=>$faker->unixTime($max = 'now'),
                'user_id'=>$i,
                'chat_id'=>$i,
            ]);
        }
    }
}
