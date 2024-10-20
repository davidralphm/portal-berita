<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    private static int $voteIndex = -1;

    public function definition(): array
    {
        VoteFactory::$voteIndex++;

        $isLike = false;

        if (rand(0, 1))
            $isLike = true;
        
        return [
            'user_id' => VoteFactory::$voteIndex % 10 + 1,
            'news_id' => intval(VoteFactory::$voteIndex / 10) + 1,
            'comment_id' => 0,
            'is_like' => $isLike
        ];
    }
}
