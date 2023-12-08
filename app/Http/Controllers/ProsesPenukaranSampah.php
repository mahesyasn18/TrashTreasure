<?php

namespace App\Http\Controllers;

use App\Models\Poin;
use App\Models\User;
use App\Models\JenisSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PenukaranSampah;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProsesPenukaranSampah extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.inputSampah.index');
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/penukaran/sampah/form');
        }

        return redirect()->route('login.penukaran')->withErrors(['email' => 'Invalid login credentials']);
    }

    public function createPenukaran()
    {

        $jenissampah = JenisSampah::get();
        return view('page.inputSampah.create', compact('jenissampah'));
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
                'jenis_sampah_id' => 'required',
                'jumlah_sampah' => 'required',
            ]);

            $sampah = new PenukaranSampah();
            $sampah->user_id = $request->input('user_id');
            $sampah->jenis_sampah_id = $request->input('jenis_sampah_id');
            $sampah->jumlah_sampah = $request->input('jumlah_sampah');
            $poin = $request->input('jumlah_sampah');
            if ($request->input('jenis_sampah_id') == 1) {
                $sampah->jumlah_point = $poin * 2;
                $poin =$poin*2;
            } elseif($request->input('jenis_sampah_id') == 2) {
                $sampah->jumlah_point = $poin * 3;
                $poin =$poin*3;
            }else{
                $sampah->jumlah_point = $poin * 5;
                $poin =$poin*5;
            }
            $sampah->save();

            $this->updatePoin($sampah->user_id, $poin);


            // ELOQUENT NYA GAADA
            Alert::success('Berhasil', 'Anda mendapatkan poin sebanyak '. $poin);
            Auth::logout();
            return redirect()->to('/penukaran/sampah');
        } catch (\Exception $e) {
            
            dd('test');
            return redirect()->back()->with('error', 'Error while create data sampah ' . $e->getMessage());
        }
    }

    public function updatePoin($user_id, $input_poin){

        $poin = Poin::where('user_id', $user_id)->first();

        if ($poin) {
            // If a record is found, update the existing record
            $poin->jumlah_poin += $input_poin;
            $poin->save();
        } else {
            // If no record is found, create a new record
            $new_poin = new Poin();
            $new_poin->user_id = $user_id;
            $new_poin->jumlah_poin = $input_poin;
            $new_poin->save();
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
