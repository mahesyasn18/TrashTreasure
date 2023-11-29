<?php

namespace App\Http\Controllers;

use App\Models\PenukaranPoin;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenukaranPoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Penukaran Poin';
        // $data = PenukaranPoin::all(); // or any other method to get the data
        return view('page.admin.riwayat.penukaranPoin', compact('title'));
    }

    public function getPenukaranPoin(Request $request)
    {
       try {
           if ($request->ajax()) {
               $data = PenukaranPoin::get();

               return DataTables::of($data)
                   ->addColumn('id', function ($row) {
                       static $index = 0;
                       $index++;
                       return $index;
                   })

                   ->addColumn('options', function ($poin) {
                       return "<a href='#' data-toggle='modal' data-target='#exampleModal{$poin->id}'><i class='fas fa-edit fa-lg'></i></a>
                               <a style='border: none; background-color:transparent;' class='hapusData' data-id='$poin->id' data-url='riwayat-penukaran-poin/{$poin->id}'><i class='fas fa-trash fa-lg text-danger'></i></a>";
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
