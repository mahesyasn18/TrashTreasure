<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news')->truncate();
        DB::table('news')->insert([
            [
                'title'   => 'Berita 1',
                'cover'   => 'default.png',
                'content' => 'ini adalah berita 1'
            ],
            [
                'title'   => 'Berita 2',
                'cover'   => 'default.png',
                'content' => 'ini adalah berita 2'
            ],
            [
                'title'   => 'Berita 3',
                'cover'   => 'default.png',
                'content' => 'ini adalah berita 3'
            ],
        ]);
    }
}
