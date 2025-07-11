<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting!

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login'); // Pastikan view ini ada
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba login menggunakan guard 'admin'
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard')); // Arahkan ke dashboard admin
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // Logout dari guard 'admin'

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login'); // Arahkan kembali ke halaman login admin
    }
}