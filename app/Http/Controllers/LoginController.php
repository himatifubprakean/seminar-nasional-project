<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class LoginController extends Controller
{
    public function showLoginForm()
    {
        if(Auth::check()){
            return redirect()->route('scan');
        }
        return view('login');
    }

    public function login(Request $request)
    {
       $request->validate([
        'nim' => 'required|numeric',
        'password' => 'required'
       ]);

       $user = User::where('nim', $request->nim)->first();

       if($user && Hash::check($request->password, $user->password)){
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('scan'));

       }
       return back()->with('error', 'NIM atau password salah');

    }
}
