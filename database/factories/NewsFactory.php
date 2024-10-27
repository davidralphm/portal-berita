<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    private static array $CATEGORIES = [
        'culinary',
        'health',
        'automotive',
        'sports',
        'politics',
        'economy',
        'technology',
    ];

    private static int $CATEGORY_INDEX = -1;

    public function definition(): array
    {
        $title = fake()->realTextBetween(32, 64);

        NewsFactory::$CATEGORY_INDEX++;
        
        return [
            'title' => $title,
            'author' => fake()->name(),
            'category' => NewsFactory::$CATEGORIES[NewsFactory::$CATEGORY_INDEX % count(NewsFactory::$CATEGORIES)],
            'slug' => Str::slug($title),
            'thumbnail_url' => '/noImage.png',
            'description' => fake()->realText(64),
            'body' => fake()->realText(512),
            'user_id' => rand(1, 10)
        ];
    }
}
