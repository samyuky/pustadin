<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        // Hanya tamu (belum login) yang bisa mengakses halaman login admin
        // 'admin' adalah nama guard yang kita gunakan untuk admin
        $this->middleware('guest:admin')->except('logout');
    }

    // Menampilkan form login admin
    public function showLoginForm()
    {
        return view('admin.login'); // Pastikan Anda memiliki file blade ini
    }

    // Memproses upaya login admin
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Coba autentikasi menggunakan guard 'admin'
        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Jika berhasil, arahkan ke dashboard admin
            return redirect()->intended(route('admin.dashboard'));
        }

        // Jika gagal, kembalikan dengan error
        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    // Logout admin
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman login admin atau halaman utama
        return redirect()->route('admin.login'); // Mengarahkan kembali ke halaman login admin
    }
}