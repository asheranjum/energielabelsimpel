<?php

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        // Product::factory()->count(50)->create();

        Product::create([
            'title' => fake()->unique()->paragraph(),
            'user_id' => 1
        ]);
    }
}
