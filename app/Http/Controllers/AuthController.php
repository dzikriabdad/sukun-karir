<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login untuk Pelamar
     */
    public function showLogin() {
        return view('auth.login');
    }

    /**
     * Menangani proses login Pelamar
     */
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Cek jika yang login ternyata Admin
            if (Auth::user()->role === 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Admin terdeteksi. Silakan login melalui halaman khusus Admin.'
                ]);
            }

            $request->session()->regenerate();

            // ====================================================================
            // KONDISI 1: PELAMAR SUDAH PUNYA AKUN DAN LOGIN
            // ====================================================================
            if (session()->has('redirect_setelah_login')) {
                $urlTujuan = session('redirect_setelah_login');
                
                // Jika belum mengisi CV, arahkan ke buat CV
                if (!Auth::user()->cv) {
                    return redirect()->route('pelamar.create_cv')
                                     ->with('info', 'Hampir selesai! Silakan lengkapi CV Anda terlebih dahulu.');
                }

                // Jika CV sudah lengkap, arahkan langsung ke halaman lamaran
                session()->forget('redirect_setelah_login');
                return redirect($urlTujuan);
            }
            // ====================================================================

            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    /**
     * Menampilkan halaman login untuk Admin HRD
     */
    public function showAdminLogin() {
        return view('auth.admin_login');
    }

    /**
     * Menangani proses login Admin HRD
     */
    public function adminLogin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akses ditolak. Halaman ini hanya untuk akun Admin.'
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended('/admin/applications');
        }

        return back()->withErrors(['email' => 'Kredensial admin tidak valid.']);
    }

    /**
     * Menangani proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil Logout!');
    }

    /**
     * Menampilkan halaman Register
     */
    public function showRegister() {
        return view('auth.register');
    }

    /**
     * Menangani proses pendaftaran Pelamar baru
     */
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pelamar',
        ]);

        Auth::login($user);

        // ====================================================================
        // KONDISI 2: PELAMAR BARU MENDAFTAR DARI LINK KHUSUS/JOBFAIR
        // ====================================================================
        if (session()->has('redirect_setelah_login')) {
            // Karena user baru pasti belum punya CV, arahkan ke pengisian CV
            return redirect()->route('pelamar.create_cv')
                             ->with('info', 'Akun berhasil dibuat! Silakan isi CV Anda untuk melanjutkan pendaftaran.');
        }

        return redirect()->route('pelamar.create_cv');
    }
}