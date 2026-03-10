<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    // 1. Menampilkan halaman form lamaran
    public function create($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        
        // Tambahan keamanan: Jika loker tutup, jangan kasih akses ke halaman form
        if ($lowongan->status !== 'aktif') {
            return redirect()->route('careers.index')->with('error', 'Maaf, lowongan ini sudah ditutup.');
        }
        
        return view('pelamar.apply', compact('lowongan'));
    }

    // 2. Memproses data lamaran (Versi Gabungan & Aman)
    public function store(Request $request, $lowonganId)
    {
        // PASANG JEBAKAN INI
        dd('WADUH BANG, DATANYA NYASAR KE SINI! CACHE-NYA BELUM BERSIH!');
        // A. AMBIL DATA LOWONGAN
        $lowongan = Lowongan::findOrFail($lowonganId);

        // B. VALIDASI FORM
        $request->validate([
            'application_reason' => 'required|string',
            'commitment'         => 'required|string',
            'relocation_ready'   => 'required|boolean',
            'expected_salary'    => 'required|numeric',
        ]);

        // C. CEK STATUS LOKER (Mencegah lamaran ke loker "Tutup")
        if ($lowongan->status !== 'aktif') {
            return redirect()->route('careers.index')->with('error', 'Maaf, lowongan ini sudah ditutup.');
        }

        // D. CEK DUPLIKASI (Mencegah melamar dua kali di posisi yang sama)
        $alreadyApplied = Application::where('user_id', Auth::id())
                                    ->where('lowongan_id', $lowonganId)
                                    ->exists();

        if ($alreadyApplied) {
            // Pesannya saya sesuaikan agar lebih jelas
            return redirect()->route('pelamar.dashboard')->with('error', 'Gagal! Kamu sudah pernah melamar di posisi ini. Silakan melamar di posisi pekerjaan lain.');
        }

        // E. SIMPAN DATA
        Application::create([
            'user_id'            => Auth::id(),
            'lowongan_id'        => $lowonganId,
            'application_reason' => $request->application_reason,
            'commitment'         => $request->commitment,
            'relocation_ready'   => $request->relocation_ready,
            'expected_salary'    => $request->expected_salary,
            'status'             => 'pending',
        ]);

        // F. REDIRECT KE DASHBOARD PELAMAR
        return redirect()->route('pelamar.dashboard')->with('success', 'Lamaran berhasil terkirim! Silakan pantau tahapan seleksi kamu.');
    }
}