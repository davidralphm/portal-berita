<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    private static int $commentIndex = -1;

    public function definition(): array
    {
        CommentFactory::$commentIndex++;

        return [
            'body' => fake()->realTextBetween(32, 256),
            'news_id' => intval(CommentFactory::$commentIndex / 100) + 1,
            'user_id' => (CommentFactory::$commentIndex % 10) + 1,
            'created_at' => now()
        ];
    }
}
