<?php

namespace Database\Seeders;

use App\Models\messenger\Message;
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
        for ($i = 0; $i <= 10; $i++) {
            Message::create([
                'text_message'=>$faker->realText($maxNbChars = 50),
                'send_time'=>$faker->unixTime($max = 'now'),
                'user_id'=>191,
            ]);
        }
    }
}
