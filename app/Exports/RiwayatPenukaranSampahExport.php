<?php

namespace App\Exports;

use App\Models\PenukaranSampah;
use Maatwebsite\Excel\Concerns\FromCollection;

class RiwayatPenukaranSampahExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PenukaranSampah::all();
    }

    public function headings(): array
    {
        return ['user_id','jumlah_sampah','jumlah_point'];
    }
}
