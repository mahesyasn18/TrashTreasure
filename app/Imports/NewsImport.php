<?php

namespace App\Imports;

use App\Models\News;
use Maatwebsite\Excel\Concerns\ToModel;

class NewsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $news = new News([
            'title'      => $row[0],
            'content'    => $row[1],
            'created_at' => $row[2],
            'updated_at' => $row[3],
        ]);

        $news->save();
        $news->image()->create([
            'url' => $row[4],
        ]);
        return $news;
    }
}
