<?php

use Illuminate\Database\Seeder;
use App\Shop;

class Shops extends Seeder
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
			Shop::create([
				'shop' => $faker->paragraph($nbSentences=3)
				//'user_id' => $faker->numberBetween($min=1, $max=5)
			]);
		}
    }
}
