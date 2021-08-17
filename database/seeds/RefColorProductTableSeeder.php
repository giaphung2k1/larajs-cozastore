<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 17:18:34
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RefColorProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $products = \App\Models\Product::all()->pluck('id')->toArray();
        $colors = \App\Models\Color::all()->pluck('id')->toArray();

        $limit = 100;

        for ($i = 0; $i < $limit; $i++){
        	\App\Models\RefColorProduct::create([
                'product_id' => $faker->randomElement($products),
                'color_id' => $faker->randomElement($colors),
                
			]);
		}
    }
}
