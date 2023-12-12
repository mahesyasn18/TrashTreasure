<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use App\Models\News;
use App\Models\Image;

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
        $newsData = [
            [
                'title' => 'Berita 1',
                'content' => 'Isi berita 1',
            ],
            [
                'title' => 'Berita 2',
                'content' => 'Isi berita 2',
            ],
            [
                'title' => 'Berita 3',
                'content' => 'Isi berita 3',
            ],
            [
                'title' => 'Berita 4',
                'content' => 'Isi berita 4',
            ],
            [
                'title' => 'Berita 5',
                'content' => 'Isi berita 5',
            ],
        ];

        foreach ($newsData as $data) {
            $news = News::create($data);

            $image = new Image([
                'url' => 'cover.png',
            ]);

            $news->image()->save($image);
        }

        Log::info('NewsSeeder is running successfully');
    }
}
