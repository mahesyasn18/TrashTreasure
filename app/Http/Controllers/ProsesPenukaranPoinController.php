<?php

namespace App\Http\Controllers;

use App\Models\PenukaranPoin;
use App\Models\Poin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProsesPenukaranPoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.inputPoin.create');
    }

    public function getPoin()
    {
        $poin = Poin::where('user_id', auth()->user()->id)->first();

        return view('page.inputPoin.create', compact('poin'));
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
                'user_id' => 'required',
                'jumlah_poin' => 'required',
            ]);

            
            $poin = new PenukaranPoin();
            $poin->user_id = $request->input('user_id');
            $poin->jumlah_poin = $request->input('jumlah_poin');
            $poin->jumlah_uang = ($poin->jumlah_poin)*100;
            $poin->save();

            $poins = Poin::where('user_id', $poin->user_id)->first();
            $poins->jumlah_poin -= $poin->jumlah_poin;
            $poins->save();

            Alert::success('Berhasil', 'Anda mendapatkan uang sebanyak '. $poin->jumlah_uang);
            
            return redirect()->to('/users/dashboard');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while create data poin ' . $e->getMessage());
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
