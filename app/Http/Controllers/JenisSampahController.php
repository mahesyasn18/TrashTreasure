<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class JenisSampahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Jenis Sampah';
        $data = JenisSampah::all(); // or any other method to get the data
        return view('page.admin.jenisSampah.index', compact('title', 'data'));
    }

    public function getJenisSampah(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = JenisSampah::get();

                return DataTables::of($data)
                    ->addColumn('id', function ($row) {
                        static $index = 0;
                        $index++;
                        return $index;
                    })

                    ->addColumn('options', function ($sampah) {
                        return "<a href='#' data-toggle='modal' data-target='#exampleModal{$sampah->id}'><i class='fas fa-edit fa-lg'></i></a>
                                <a style='border: none; background-color:transparent;' class='hapusData' data-id='$sampah->id' data-url='sampah/{$sampah->id}'><i class='fas fa-trash fa-lg text-danger'></i></a>";
                    })
                    ->rawColumns(['options'])
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
        try {
            $request->validate([
                'jenis_sampah' => 'required',

            ]);



            $sampah = new JenisSampah();
            $sampah->jenis_sampah = $request->input('jenis_sampah');
            $sampah->save();

            Alert::success('Berhasil', 'Data berhasil ditambah');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while create data sampah ' . $e->getMessage());
        }
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
    try {
        $request->validate([
            'jenis_sampah' => 'required',
        ]);

        $sampah = JenisSampah::find($id);
        if (!$sampah) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        $sampah->jenis_sampah = $request->input('jenis_sampah');
        $sampah->save();

        Alert::success('Berhasil', 'Data berhasil diupdate');
        return redirect()->back();
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error while updating data sampah ' . $e->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $sampah = JenisSampah::find($id);

            if (!$sampah) {
                return redirect()->back()->with('error', 'Data Jenis Sampah tidak ditemukan.');
            }


            $sampah->delete();

            return response()->json([
                'msg' => 'Data yang dipilih telah Dihapus'
            ]);

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error while deleting data sampah: ' . $e->getMessage());
        }
    }
}
