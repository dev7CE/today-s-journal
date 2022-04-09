<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stories')->insert([
            'user_id' => 1,
            'title' => 'Story 1',
            'url' => 'story-1',
            'content' => Str::random(10)
        ]);

        DB::table('stories')->insert([
            'user_id' => 1,
            'title' => 'Story 2',
            'url' => 'story-2',
            'content' => Str::random(10)
        ]);
    }
}
