<?php

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogsCount=(int) $this->command->ask('How many users would you like?', 50);
        $users=App\User::all();

        factory(App\BlogPost::class, $blogsCount)->make()->each(function($post) use ($users) {
            $post->user_id=$users->random()->id;
            $post->save();
        });
    }
}
