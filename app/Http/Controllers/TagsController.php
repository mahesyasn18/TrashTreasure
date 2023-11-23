<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'News Category';
        $data = Tags::all(); // or any other method to get the data
        return view('page.admin.news.category', compact('title', 'data'));
    }

    public function getNewsCategory(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Tags::get();
    
                return datatables()->of($data)
                    ->addColumn('id', function ($row) {
                        static $index = 0;
                        $index++;
                        return $index;
                    })
                    ->addColumn('options', function ($tags) {
                        return "<a href='#' data-toggle='modal' data-target='#exampleModal{$tags->id}'><i class='fas fa-edit fa-lg'></i></a>
                                <a style='border: none; background-color:transparent;' class='hapusData' data-id='$tags->id' data-url='news-category/{$tags->id}'><i class='fas fa-trash fa-lg text-danger'></i></a>";
                    })
                    ->rawColumns(['options'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error while showing data: ' . $e->getMessage()], 500);
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
        try {
            $request->validate([
                'nama' => 'required',

            ]);



            $tag = new Tags();
            $tag->nama = $request->input('nama');
            $tag->save();

            Alert::success('Berhasil', 'Data berhasil ditambah');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while create data tags ' . $e->getMessage());
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
            ]);
    
            $tag = Tags::find($id);
            if (!$tag) {
                return redirect()->back()->with('error', 'Data not found.');
            }
    
            $tag->nama = $request->input('nama');
            $tag->save();
    
            Alert::success('Berhasil', 'Data berhasil diupdate');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while updating category berita ' . $e->getMessage());
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
            $tag = Tags::find($id);

            if (!$tag) {
                return redirect()->back()->with('error', 'Data Jenis Sampah tidak ditemukan.');
            }


            $tag->delete();

            return response()->json([
                'msg' => 'Data yang dipilih telah Dihapus'
            ]);

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error while deleting data sampah: ' . $e->getMessage());
        }
    }
}
