<?php

namespace App\Exports;

use App\Models\News;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Carbon\Carbon;

class NewsExport implements FromCollection, WithMapping, WithHeadings, WithDrawings
{
    private $id = 1;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $newsData = News::with('tags')->select('id','title', 'cover','created_at', 'updated_at')->get();
    
        return $newsData;

    }

    /**
    * @var News $news
    */
    public function map($item): array
    {
        return [
            $this->id++,
            ucwords($item->title),
            $item->tags->pluck('nama')->implode(', '),
            $item->cover,
            Carbon::parse($item->created_at)->format('d-m-Y H:i:s'),
            Carbon::parse($item->updated_at)->format('d-m-Y H:i:s'),
        ];
    }

    /**
    * Add header to the sheet.
    *
    * @var News $news
    */
    public function headings(): array
    {
        return [
            'No',
            'Title',
            'Tags',
            'Cover',
            'Created At',
            'Updated At',
        ];
    }

    /**
    * Add drawings (images) to the sheet.
    *
    * @var News $news
    */
    public function drawings()
    {
        $idForDrawings = 2;
        $drawings = [];

        foreach (News::all() as $news) {
            $drawing = new Drawing();
            $drawing->setName($news->title);
            $drawing->setDescription($news->title);
            $drawing->setPath(public_path('/storage/'.$news->cover));
            $drawing->setCoordinates('D' . $idForDrawings++); // Assuming the 'cover' is in column C
            $drawing->setWidth(50);
            $drawing->setHeight(50);

            $drawings[] = $drawing;
        }

        return $drawings;
    }
}
