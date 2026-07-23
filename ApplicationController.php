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

    // 2. Memproses data lamaran (Versi Anti Duplicate Entry)
    public function store(Request $request, $lowonganId)
    {
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

        // D. CEK RIWAYAT LAMARAN (Anti Duplicate Entry)
        $existingApplication = Application::where('user_id', Auth::id())
                                          ->where('lowongan_id', $lowonganId)
                                          ->first();

        if ($existingApplication) {
            // Jika sudah pernah melamar dan statusnya "Ditolak", beri Kesempatan Kedua (Update)
            if ($existingApplication->status === 'rejected') {
                $existingApplication->update([
                    'application_reason' => $request->application_reason,
                    'commitment'         => $request->commitment,
                    'relocation_ready'   => $request->relocation_ready,
                    'expected_salary'    => $request->expected_salary,
                    'status'             => 'screening', // Kembalikan ke tahap awal
                ]);

                return redirect()->route('pelamar.dashboard')->with('success', 'Lamaran ulang berhasil terkirim! Semoga beruntung di kesempatan kedua ini.');
            } 
            // Jika statusnya masih diproses / diterima, tolak lamarannya
            else {
                return redirect()->route('pelamar.dashboard')->with('error', 'Gagal! Lamaran kamu untuk posisi ini masih diproses atau sudah diterima.');
            }
        }

        // E. JIKA BELUM PERNAH MELAMAR SAMA SEKALI, SIMPAN DATA BARU
        Application::create([
            'user_id'            => Auth::id(),
            'lowongan_id'        => $lowonganId,
            'application_reason' => $request->application_reason,
            'commitment'         => $request->commitment,
            'relocation_ready'   => $request->relocation_ready,
            'expected_salary'    => $request->expected_salary,
            'status'             => 'screening', // Disamakan dengan sistem funnel HRD
        ]);

        // F. REDIRECT KE DASHBOARD PELAMAR
        return redirect()->route('pelamar.dashboard')->with('success', 'Lamaran berhasil terkirim! Silakan pantau tahapan seleksi kamu.');
    }
}