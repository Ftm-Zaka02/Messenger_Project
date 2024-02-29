<?php

namespace Database\Factories;
use App\Models\messenger\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\messenger\Message>
 */
class MessageFactory extends Factory
{
    protected $Message=Message::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
//        return [
//            'text_message' => $this->faker->realText($maxNbChars = 100),
//            'send_time' => $this->faker->unixTime($max = 'now'),
//            'user_id' => 191,
//            'chat_name' => 'farawin',
//            'deleted' => 0
//        ];
    }
}
