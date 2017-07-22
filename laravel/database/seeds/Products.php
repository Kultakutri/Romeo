<?php

use Illuminate\Database\Seeder;

use App\Product;

class Products extends Seeder
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
			Product::create([
				'nimi' => $faker->text($maxNbChars = 100),
				'valmistaja' => $faker->text($maxNbChars = 60),
				'koko' => $faker->numberBetween($min=1, $max=5)
			]);
		}
    }
}
