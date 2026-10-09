<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    use FakeImageTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(4),
            'price' => fake()->numberBetween(1000, 10000),
            'image' => $this->getFakeImage(),
            'is_published' => fake()->boolean(80),
        ];
    }
}
