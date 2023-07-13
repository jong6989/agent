<?php

namespace App\Database\Seeds;

use App\Models\AccountModel;
use CodeIgniter\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $account = new AccountModel();
        $faker = \Faker\Factory::create();

        $account->save(
            [
                'email' => $faker->email(),
                'password' => password_hash('123456', PASSWORD_BCRYPT),
                'name' => $faker->name(),
                'commission' => 26,
                'wallet' => 0,
                'ageny' => '',
                'operator' => 2,
                'super_agent' => 5,
                'address' => 'Barangay 11 CALOOCAN CITY NCR, THIRD DISTRICT ',
                'bank_name' => 'Gcash',
                'account_number' => $faker->numerify('###########'),
                'account_name' => $faker->name(),
                'phone' => $faker->numerify('###########'),
                'fb' => '',
                'online'=> 0,
                'status' => 'active',
                'access' => 'agent',


            ]
            );
    }
}
