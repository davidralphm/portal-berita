<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\News::factory(50)->create();
        \App\Models\Comment::factory(50 * 100)->create();
        \App\Models\Vote::factory(50 * 10)->create();

        // Create main admin user

        DB::table('users')->insert([
            'name' => 'administrator',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin123'),
            'type' => 'admin'
        ]);

        // Create comment replies

        for ($i = 0; $i < 5000; $i++) {
            DB::table('comments')->insert([
                'created_at' => now(),
                'body' => fake()->realTextBetween(32, 128),
                'user_id' => rand(1, 10),
                'news_id' => 0,
                'comment_id' => rand(1, 5000)
            ]);
        }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
