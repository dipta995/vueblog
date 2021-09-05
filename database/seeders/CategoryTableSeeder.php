<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Seeders\Faker\Factory;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
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
            $category = $faker->unique()->name;
            Category::create([
                "name"=>$category,
                "slug"=>slugify($category),
                "status"=>rand(0,1),
                
                
            ]);
        }
    }
 
}
