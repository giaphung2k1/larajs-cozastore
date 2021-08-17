<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2021-08-17 12:31:00
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductRejectTableSeeder extends Seeder
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

        $limit = 100;

        for ($i = 0; $i < $limit; $i++){
        	\App\Models\ProductReject::create([
                'total' => $faker->numberBetween(1000, 9000),
                'price' => $faker->randomFloat(2, 1000, 9000),
                'note' => $faker->name,
                'product_id' => $faker->randomElement($products),
                //{{SEEDER_NOT_DELETE_THIS_LINE}}
			]);
		}
    }
}
