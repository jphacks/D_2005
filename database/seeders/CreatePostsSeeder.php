<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class CreatePostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();
        Post::factory()->count(10)->create();
    }
}
