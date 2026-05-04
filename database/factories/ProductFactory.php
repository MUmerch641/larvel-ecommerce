<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'category_id' => null,
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(100, 999),
            'description' => $this->faker->optional()->paragraph(),
            'price_cents' => $this->faker->numberBetween(100, 50000),
            'sku' => $this->faker->optional()->bothify('SKU-####'),
            'is_active' => true,
            'stock' => $this->faker->numberBetween(0, 100),
            'featured_image_path' => null,
        ];
    }
}
