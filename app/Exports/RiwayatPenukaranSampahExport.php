<?php

namespace App\Exports;

use App\Models\PenukaranSampah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RiwayatPenukaranSampahExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $penukaranSampahCollection = PenukaranSampah::with("users", "jenissampah")
            ->get(['user_id','jenis_sampah_id','jumlah_point', 'jumlah_sampah', 'created_at']);

        $penukaranSampahCollection->map(function ($item) {
            $item->created_at = Carbon::parse($item->created_at)->format('d-m-Y H:i:s');
            $item->jumlah_sampah .= ' kg';
            $item->nama = $item->users->name;
            $item->jenis_sampah = $item->jenissampah->jenis_sampah;
            return $item;
        });

        return $penukaranSampahCollection->map(function ($item) {
            return [
                'nama' =>  $item->users->name,
                'jenis_sampah' => $item->jenissampah->jenis_sampah,
                'jumlah_point' => $item->jumlah_point,
                'jumlah_sampah' => $item->jumlah_sampah,
                'created_at' => $item->created_at,

            ];
        });
    }

    public function headings(): array
    {
        return ['nama', 'jenis_sampah','jumlah_point', 'jumlah_sampah', 'created_at'];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply border to all cells
        $sheet->getStyle('A1:E' . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle('thin');

        return [
            1 => ['font' => ['bold' => true]], // Make the first row bold
        ];
    }
}
