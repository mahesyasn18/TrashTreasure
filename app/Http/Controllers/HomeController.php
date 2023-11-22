<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        return view('page.admin.profile');
    }

    public function updateprofile(Request $request)
    {
        try{
            $usr = User::findOrFail(Auth::user()->id);
            if ($request->input('type') == 'change_profile') {
                $this->validate($request, [
                    'name' => 'string|max:200|min:3',
                    'email' => 'string|min:3|email',
                    'user_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
                    'phone_number' => 'max:13|min:10',
                ]);
                $img_old = Auth::user()->user_image;
                if ($request->file('user_image')) {
                    # delete old img
                    if ($img_old && file_exists(public_path().$img_old)) {
                        unlink(public_path().$img_old);
                    }
                    $nama_gambar = time() . '_' . $request->file('user_image')->getClientOriginalName();
                    Storage::put('public/profiles/'. $nama_gambar, $request->file('user_image')->get());
                    $img_old = $nama_gambar;
                }
                $usr->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'user_image' => $img_old,
                        'phone_number' => $request->phone_number,
                        'account_number' => $request->account_number,
                        'address' => $request->address
                    ]);
                return redirect()->route('profile')->with('status', 'Perubahan telah tersimpan');
            } elseif ($request->input('type') == 'change_password') {
                $this->validate($request, [
                    'password' => 'min:8|confirmed|required',
                    'password_confirmation' => 'min:8|required',
                ]);
                $usr->update([
                    'password' => Hash::make($request->password)
                ]);
                return redirect()->route('profile')->with('status', 'Perubahan telah tersimpan');
            }
        }catch(\Exception $e){
            Alert::error('Error', 'Error while updating data user: ' . $e->getMessage());
        }
    }
}
