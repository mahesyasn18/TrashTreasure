<?php

namespace App\Http\Controllers;

use App\Models\DropPoint;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DropPointExport;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class DropPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Drop Point';
        $data = DropPoint::all(); // or any other method to get the data
        return view('page.admin.drop_points.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getDropPoint(Request $request)
     {
        try {
            if ($request->ajax()) {
                $data = DropPoint::get();

                return DataTables::of($data)
                    ->addColumn('id', function ($row) {
                        static $index = 0;
                        $index++;
                        return $index;
                    })

                    ->addColumn('options', function ($dpoint) {
                        return "<a href='#' data-toggle='modal' data-target='#exampleModal{$dpoint->id}'><i class='fas fa-edit fa-lg'></i></a>
                                <a style='border: none; background-color:transparent;' class='hapusData' data-id='$dpoint->id' data-url='drop-point/{$dpoint->id}'><i class='fas fa-trash fa-lg text-danger'></i></a>";
                    })
                    ->rawColumns(['options'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while showing data: ' . $e->getMessage());
        }
     }

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
                'nama' => 'required',
                'alamat' => 'required',
            ]);



            $dpoint = new DropPoint();
            $dpoint->nama = $request->input('nama');
            $dpoint->alamat = $request->input('alamat');
            $dpoint->save();

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
                'nama' => 'required',
                'alamat' => 'required',
            ]);
    
            $dpoint = DropPoint::find($id);
            if (!$dpoint) {
                return redirect()->back()->with('error', 'Data not found.');
            }
    
            $dpoint->nama = $request->input('nama');
            $dpoint->alamat = $request->input('alamat');
            $dpoint->save();
    
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
            $dpoint = DropPoint::find($id);

            if (!$dpoint) {
                return redirect()->back()->with('error', 'Data Jenis Sampah tidak ditemukan.');
            }


            $dpoint->delete();

            return response()->json([
                'msg' => 'Data yang dipilih telah Dihapus'
            ]);

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error while deleting data sampah: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new DropPointExport, 'DropPoint.xlsx');
    }
}
