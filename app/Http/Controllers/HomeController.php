<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

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
            $usr = User::findOrFail(Auth::user()->id);
            if ($request->input('type') == 'change_profile') {
                $this->validate($request, [
                    'name' => 'string|max:200|min:3',
                    'email' => 'string|min:3|email',
                    'user_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:1024',
                    'phone_number' => 'max:13|min:10',
                ]);

                if ($request->hasFile('user_image')) {
                    $usr->image?->url ? Storage::delete('public/' . $usr->image->url) : null;
                    $coverPath = $request->file('user_image')->store('profiles', 'public');
                    $usr->image()->updateOrCreate([], ['url' => $coverPath]);
                }

                $usr->update([
                        'name' => $request->name,
                        'email' => $request->email,
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
    }
}
