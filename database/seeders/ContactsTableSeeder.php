<?php

namespace Database\Seeders;

use App\Models\messenger\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
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
            Contact::create([
                'phone'=>$faker->e164PhoneNumber,
                'name'=>$faker->name,
            ]);
        }
    }
}
