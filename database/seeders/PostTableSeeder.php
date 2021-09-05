<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Database\Seeders\Faker\Factory;
use Faker\Factory as FakerFactory;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =FakerFactory::create();
        foreach(range(1,10) as $index)
        {
            $name = $faker->sentence;
            Post::create([
                "user_id"=>rand(1,20),
                "category_id"=>rand(1,5),
                "title"=>$name,
                "slug"=>slugify($name),
                "content"=>$faker->paragraph,
                "thumbnail"=>$faker->imageUrl(),
                "status"=>$this->getRandomStatus(),
                
            ]);
        }
    }
    public function getRandomStatus()
    {
        $statuses = array('draft','published');
        return $statuses[array_rand($statuses)];
    }
    
}
