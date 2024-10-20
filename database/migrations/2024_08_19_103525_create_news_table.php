<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title', 256);
            $table->string('author', 256);
            $table->string('category', 64);
            $table->string('slug', 256);
            $table->string('thumbnail_url', 64)->nullable()->default('/noImage.png');
            $table->text('description')->nullable();
            $table->text('body');

            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
