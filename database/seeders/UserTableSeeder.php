<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Faker\Factory;
use Faker\Factory as FakerFactory;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $faker = FakerFactory::create();
        foreach(range(1,20) as $index)
        {
            User::create([
                "name"=>$faker->name,
                "email"=>$faker->email,
                "password"=>bcrypt("12345678"),
                
            ]);
        }
    }
}
