<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class AkunController extends Controller
{
    public function index()
    {
        $title = 'Account';
        return view('page.admin.akun.index', compact('title'));
    }

    public function getUsersData(Request $request)
    {
        try{
            if ($request->ajax()) {
                $data = User::where('id','!=',Auth::id())->get();

                $data->transform(function ($item) {
                    $item->created_at_formatted = Carbon::parse($item->created_at)->format('d F Y');
                    return $item;
                });

                return Datatables::of($data)
                    ->addColumn('id', function($row) {
                        static $index = 0;
                        $index++;
                        return $index;
                    })
                    ->addColumn('created_at', function ($row) {
                        return $row->created_at_formatted;
                    })
                    ->addColumn('options', function ($row) {
                        return "<a href='users/{$row->id}/edit'><i class='fas fa-edit fa-lg'></i></a>
                                <a style='border: none; background-color:transparent;' class='hapusData' data-id='$row->id' data-url='users/{$row->id}'><i class='fas fa-trash fa-lg text-danger'></i></a>";
                    })
                    ->rawColumns(['options'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Error while showing data users: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function create()
    {
        return view('page.admin.akun.addAkun');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200|min:3',
            'email' => 'required|string|min:3|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'role_user_id' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambah');
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        try{
            $data = User::find($id);
            return view('page.admin.akun.ubahAkun', compact('data'));
        }catch(\Exception $e){
            Alert::error('Error', 'Error while showing data users: '. $e);
        }
    }

    public function update($id, Request $request)
    {
        $data = User::find($id);

        $request->validate([
            'name' => 'required|string|max:200|min:3',
            'email' => 'required|string|min:3|email|unique:users,email,'.$data->id,
            'password' => $request->filled('password') ? 'min:8|confirmed' : 'nullable',
        ]);

        $data->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambah');
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        try{
            $user = User::find($id);

            if (!$user) {
                return redirect()->back()->with('error', 'Data user tidak ditemukan.');
            }

            Storage::delete('public/profiles/' . $user->user_image);
            $user->delete();

            return response()->json([
                'msg' => 'Data yang dipilih telah dihapus'
            ]);

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error while deleting data user: ' . $e->getMessage());
        }
    }
}
