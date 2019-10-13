<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // DB::table('users')->insert([
        //     'name' => 'John Doe',
        //     'email' => 'johndoe@mail.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10)
        // ]);

        //factory(App\User::class, 20)->create();

        /*
        $doe=factory(App\User::class)->states('john-doe')->create();
        $other=factory(App\User::class, 20)->create();
        $users=$other->concat([$doe]);
        //dd($users->count());

        $posts=factory(App\BlogPost::class, 50)->make()->each(function($post) use ($users) {
            $post->user_id=$users->random()->id;
            $post->save();
        });

        $comments=factory(App\Comment::class, 150)->make()->each(function($comment) use ($posts) {
            $comment->blog_post_id=$posts->random()->id;
            $comment->save();
        });
        */

        if($this->command->confirm('Do you want to refresh the database?', true)) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        } else {
            return;
        }

        $this->call([
            UsersTableSeeder::class,
            BlogPostsTableSeeder::class,
            CommentsTableSeeder::class,
            TagsTableSeeder::class,
            BlogPostTagTableSeeder::class
        ]);
    }
}
