<?php

use Illuminate\Database\Seeder;
use App\Shop;
use App\User;
use App\UserShop;

class UserShops extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $faker = Faker\Factory::create(); 
 
        foreach(range(1,30) as $index)
        {
            UserShop::create([                
                'shop_id' => $faker->numberBetween($min = 1, $max = 5) ,
                'user_id' =>$faker->numberBetween($min = 1, $max = 5)
            ]);
        }
    }
}
