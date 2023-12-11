<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        News::truncate();
        News::create([
            [
                'title'   => 'Berita 1',
                'cover'   => 'cover.png',
                'content' => 'ini adalah berita 1'
            ],
            [
                'title'   => 'Berita 2',
                'cover'   => 'cover.png',
                'content' => 'ini adalah berita 2'
            ],
            [
                'title'   => 'Berita 3',
                'cover'   => 'cover.png',
                'content' => 'ini adalah berita 3'
            ],
        ]);

        Log::info('NewsSeeder is running successfully');
    }
}
