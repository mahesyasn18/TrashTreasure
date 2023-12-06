<?php

namespace App\Exports;

use App\Models\DropPoint;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

class DropPointExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $DPCollection = DropPoint::select("nama", "alamat", "created_at", "updated_at")->get();

        $DPCollection->map(function ($item) {
            $item->created_at = Carbon::parse($item->created_at)->format('d-m-Y H:i:s');
            $item->updated_at = Carbon::parse($item->updated_at)->format('d-m-Y H:i:s');

            return $item;
        });

        return $DPCollection;
    }

    public function headings(): array
    {
        return ["nama", "alamat", "created_at", "updated_at"]; // Change 'Tanggal' to 'created_at'
    }

    
}
