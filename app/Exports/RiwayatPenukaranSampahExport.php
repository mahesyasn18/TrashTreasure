<?php

namespace App\Exports;

use App\Models\PenukaranSampah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class RiwayatPenukaranSampahExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $penukaranSampahCollection = PenukaranSampah::with("users", "jenissampah")->select("user_id","jenis_sampah_id", "jumlah_sampah", "jumlah_point", "created_at")->get();
        $penukaranSampahCollection->map(function ($item) {
            $item->jumlah_sampah .= ' kg';
            $item->created_at = Carbon::parse($item->created_at)->format('d-m-Y H:i:s');
            $item->nama = $item->users->name;
            $item->jenis = $item->jenissampah->jenis_sampah;

            return $item;
        });

        return $penukaranSampahCollection;
    }

    public function headings(): array
    {
        return ['user_id', 'jumlah_sampah', 'jumlah_point', 'created_at', 'nama', 'jenis_sampah']; // Change 'Tanggal' to 'created_at'
    }
}
