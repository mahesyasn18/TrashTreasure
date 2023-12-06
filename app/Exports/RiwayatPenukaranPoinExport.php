<?php

namespace App\Exports;

use App\Models\PenukaranPoin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RiwayatPenukaranPoinExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $penukaranPoinCollection = PenukaranPoin::with("users")->select("user_id", "jumlah_poin", "jumlah_uang", "created_at")->get();

        // Append "kg" to the "jumlah_sampah" values and format the date
        $penukaranPoinCollection->map(function ($item) {
            $item->jumlah_poin .= ' point';
            $item->jumlah_uang = 'Rp. '.$item->jumlah_uang;
            $item->created_at = Carbon::parse($item->created_at)->format('d-m-Y H:i:s');
            $item->nama = $item->users->name;

            return $item;
        });

        return $penukaranPoinCollection;
    }

    public function headings(): array
    {
        return ["user_id", "jumlah_poin", "jumlah_uang", "created_at", 'nama']; // Change 'Tanggal' to 'created_at'
    }
}
