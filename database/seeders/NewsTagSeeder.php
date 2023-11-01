<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news_tags')->truncate();
        DB::table('news_tags')->insert([
            [
                'tag_id'  => 1,
                'news_id' => 1,
            ],
            [
                'tag_id'  => 1,
                'news_id' => 2,
            ],
            [
                'tag_id'  => 1,
                'news_id' => 3,
            ],
            [
                'tag_id'  => 2,
                'news_id' => 2,
            ],
            [
                'tag_id'  => 2,
                'news_id' => 3,
            ],
            [
                'tag_id'  => 3,
                'news_id' => 3,
            ],
        ]);
    }
}
