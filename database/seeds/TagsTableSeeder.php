<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags=collect(['Science', 'Sport', 'Politics', 'Entertainment', 'Econony']);

        $tags->each(function($tagname) {
            $tag=new Tag();
            $tag->name=$tagname;
            $tag->save();
        });
    }
}
