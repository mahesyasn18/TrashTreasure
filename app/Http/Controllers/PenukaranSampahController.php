<?php

namespace App\Http\Controllers;

use App\Exports\RiwayatPenukaranSampahExport;
use App\Models\JenisSampah;
use App\Models\PenukaranSampah;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PenukaranSampahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Riwayat Penukaran Sampah';
        return view('page.admin.riwayat.penukaranSampah', compact('title'));
    }

    public function getPenukaranSampah(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = PenukaranSampah::with("users", "jenissampah")->get();

                return DataTables::of($data)
                    ->addColumn('id', function ($row) {
                        static $index = 0;
                        $index++;
                        return $index;
                    })
                    ->addColumn('user_id', function ($row) {
                        return $row->users->name;
                    })
                    ->addColumn('jenis_sampah_id', function ($row) {
                        return $row->jenissampah->jenis_sampah;
                    })
                    ->make(true);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while showing data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function export()
    {
        return Excel::download(new RiwayatPenukaranSampahExport, 'Rekap Penukaran Sampah Menjadi Poin.xlsx');
    }
}
