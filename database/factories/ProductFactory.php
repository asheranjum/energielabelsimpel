<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'short_desc' => '</p>'.$this->faker->sentence.'</p>',
            'long_desc' => '<p style="text-align: center;">Designed with accomplishment in mind, this coffee table is definitely an ideal selection for all modern sofas. Its upgraded features, such as the highest quality tempered glass, make this a must-have. If you want to make a statement, this is your coffee table. most suitable for modern-day living.</p>',
            'regular_price' => $this->faker->randomFloat(2, 10, 100),
            'images' => '[
                "products/June2023/kHSBl2dSF0H57fVDr5J0.jpg",
                "products/June2023/ORJ9KPGqaYLqufXM09ls.jpg",
                "products/June2023/pV31Rs3wr6t8xgMeklRR.jpg",
                "products/June2023/JmlGLO5eE6Xz6PFNoGC8.jpg"
            ]',
            'sale_price' => $this->faker->randomFloat(2, 10, 100),
            'SKU' => $this->faker->randomFloat(2, 10, 100),
            'status' => 'PUBLISHED',
            'category_id' => 7,
            'sub_category_id' => 0,
            'stock_status' => 'inStock',
            // Add more attributes as needed
        ];
    }
}
