<?php

namespace App\Database\Seeds;

use App\Models\PlayerModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PlayersSeeder extends Seeder
{
    public function run()
    {
        $players = new PlayerModel();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5000; $i++) {
            $players->save(
                [
                    'name'        =>    $faker->name,
                    'email'       =>    $faker->email,
                    'phone'       =>    $faker->numerify('###########'),
                    'player_id'   =>    'none',
                    'note'        =>    '',
                    'operator'    =>      2,
                    'agency'      =>      '',
                    'super_agent' =>      5,
                    'agent'       =>      303,
                    'created_at'  =>    Time::createFromTimestamp($faker->unixTime()),
                    'updated_at'  =>    Time::now()

                ]
            );
        }
    }
}
