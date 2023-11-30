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
        return new News([
            'title'      => $row[0],
            'cover'      => $row[1],
            'content'    => $row[2],
            'created_at' => $row[3],
            'updated_at' => $row[4],
        ]);
    }
}
