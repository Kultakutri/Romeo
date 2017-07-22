<?php

use Illuminate\Database\Seeder;

use App\Product;
use App\ProductList;
use App\Lista;

class ProductLists extends Seeder
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
            ProductList::create([                
                'list_id' => $faker->numberBetween($min = 1, $max = 5) ,
                'product_id' =>$faker->numberBetween($min = 1, $max = 5)
            ]);
        }
    }
}
