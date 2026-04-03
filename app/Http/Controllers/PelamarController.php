<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cv;
use App\Models\Application;
use App\Models\Lowongan;

class PelamarController extends Controller
{
    /**
     * =================================================================
     * 1. DASHBOARD PELAMAR
     * =================================================================
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $applications = Application::where('user_id', $user->id)
                        ->with('lowongan')
                        ->latest()
                        ->get();

        return view('pelamar.dashboard', compact('user', 'applications'));
    }

    /**
     * =================================================================
     * 2. TAMPILKAN HALAMAN FORMULIR LAMARAN
     * =================================================================
     */
    public function showApplyForm($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        
        // LOGIKA FINAL: Cek apakah pelamar masih punya lamaran yang SEDANG DIPROSES
        // Kalau statusnya udah 'rejected', ini bakal false dan form lamaran terbuka!
        $hasActiveApplication = Application::where('user_id', Auth::id())
                             ->where('lowongan_id', $id)
                             ->where('status', '!=', 'rejected') 
                             ->exists();
                                    
        return view('pelamar.apply', compact('lowongan', 'hasActiveApplication'));
    }

    /**
     * =================================================================
     * 3. PROSES MELAMAR PEKERJAAN (APPLY JOB)
     * =================================================================
     */
    public function applyJob(Request $request, $id) 
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                             ->with('info', 'Silakan buat akun atau login terlebih dahulu.');
        }

        $user = Auth::user();

        if (!$user->cv) {
            return redirect()->route('pelamar.create_cv')
                             ->with('info', 'Hampir selesai! Isi CV kamu dulu ya sebelum melamar.');
        }

        $request->validate([
            'application_reason' => 'required|string',
            'commitment'         => 'required|string',
            'relocation_ready'   => 'nullable|boolean', 
            'expected_salary'    => 'nullable|numeric', 
        ]);

        $lowongan = Lowongan::findOrFail($id);
        
        if ($lowongan->status !== 'aktif') {
            return back()->with('error', 'Maaf, lowongan ini sudah ditutup.');
        }

        // PROTEKSI GANDA SAAT SIMPAN: Pastikan tidak ada lamaran aktif (kecuali yang udah rejected)
        $hasActiveApplication = Application::where('user_id', $user->id)
                             ->where('lowongan_id', $id)
                             ->where('status', '!=', 'rejected')
                             ->exists();
        
        if ($hasActiveApplication) {
            return back()->with('error', 'Gagal! Kamu masih memiliki lamaran yang sedang diproses di posisi ini.');
        }

        Application::create([
            'user_id'            => $user->id,
            'lowongan_id'        => $id,
            'application_reason' => $request->application_reason,
            'commitment'         => $request->commitment,
            'relocation_ready'   => $request->relocation_ready ?? 0,
            'expected_salary'    => $request->expected_salary ?? 0,
            'status'             => 'screening', 
        ]);

        return redirect()->route('pelamar.dashboard')->with('success', 'Lamaran berhasil dikirim!');
    }

    /**
     * =================================================================
     * 4. TAMPILKAN FORMULIR BUAT CV
     * =================================================================
     */
    public function createCv()
    {
        return view('pelamar.create_cv');
    }

    /**
     * =================================================================
     * 5. SIMPAN DATA CV & PROFIL PELAMAR
     * =================================================================
     */
    public function storeCv(Request $request)
    {
        // LOGIKA DINAMIS: Cek jenjang buat nentuin max nilai
        $jenjangKuliah = ['D3', 'S1/D4', 'S2', 'S3'];
        $maxNilai = in_array($request->last_education, $jenjangKuliah) ? 4.00 : 100.00;

        $request->validate([
            'phone_number'    => 'required|numeric',
            'place_of_birth'  => 'required|string',
            'date_of_birth'   => 'required|date', 
            'gender'          => 'required|string',
            'religion'        => 'required|string',
            'marital_status'  => 'required|string',
            'last_education'  => 'required|string',
            'university'      => 'required|string',
            'major'           => 'required|string',
            'gpa'             => "required|numeric|between:0,$maxNilai",
            'address'         => 'required|string',
            'experience'      => 'required|string',
            'file_cv'         => 'required|mimes:pdf|max:2048',
        ]);

        try {
            $fileName = time() . '_' . Auth::id() . '.pdf';
            $request->file_cv->move(public_path('uploads/cv'), $fileName);

            Cv::create([
                'user_id'         => Auth::id(),
                'full_name'       => Auth::user()->name, 
                'identity_number' => null, 
                'phone_number'    => $request->phone_number,
                'gender'          => $request->gender,
                'religion'        => $request->religion,
                'marital_status'  => $request->marital_status,
                'place_of_birth'  => $request->place_of_birth,
                'date_of_birth'   => $request->date_of_birth,
                'address'         => $request->address,
                'last_education'  => $request->last_education,
                'university'      => $request->university,
                'major'           => $request->major,
                'gpa'             => $request->gpa,
                'experience'      => $request->experience,
                'file_cv'         => $fileName,
            ]);

            return redirect()->route('pelamar.dashboard')->with('success', 'Profil dan CV Berhasil Disimpan!');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['sistem_error' => 'Gagal menyimpan CV: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * =================================================================
     * 6. TAMPILKAN FORMULIR EDIT CV
     * =================================================================
     */
    public function editCv()
    {
        $cv = Auth::user()->cv;
        if (!$cv) {
            return redirect()->route('pelamar.create_cv')->with('info', 'Anda belum memiliki CV untuk diedit.');
        }
        return view('pelamar.create_cv', compact('cv'));
    }

    /**
     * =================================================================
     * 7. PROSES UPDATE DATA CV
     * =================================================================
     */
    public function updateCv(Request $request)
    {
        $cv = Auth::user()->cv;

        // LOGIKA DINAMIS: Cek jenjang buat nentuin max nilai
        $jenjangKuliah = ['D3', 'S1/D4', 'S2', 'S3'];
        $maxNilai = in_array($request->last_education, $jenjangKuliah) ? 4.00 : 100.00;

        $request->validate([
            'phone_number'    => 'required|numeric',
            'place_of_birth'  => 'required|string',
            'date_of_birth'   => 'required|date', 
            'gender'          => 'required|string',
            'religion'        => 'required|string',
            'marital_status'  => 'required|string',
            'last_education'  => 'required|string',
            'university'      => 'required|string',
            'major'           => 'required|string',
            'gpa'             => "required|numeric|between:0,$maxNilai",
            'address'         => 'required|string',
            'experience'      => 'required|string',
            'file_cv'         => 'nullable|mimes:pdf|max:2048', 
        ]);

        try {
            $dataToUpdate = [
                'phone_number'    => $request->phone_number,
                'gender'          => $request->gender,
                'religion'        => $request->religion,
                'marital_status'  => $request->marital_status,
                'place_of_birth'  => $request->place_of_birth,
                'date_of_birth'   => $request->date_of_birth,
                'address'         => $request->address,
                'last_education'  => $request->last_education,
                'university'      => $request->university,
                'major'           => $request->major,
                'gpa'             => $request->gpa,
                'experience'      => $request->experience,
            ];

            if ($request->hasFile('file_cv')) {
                $oldFilePath = public_path('uploads/cv/' . $cv->file_cv);
                if (file_exists($oldFilePath) && !is_dir($oldFilePath)) {
                    unlink($oldFilePath);
                }
                $fileName = time() . '_' . Auth::id() . '.pdf';
                $request->file_cv->move(public_path('uploads/cv'), $fileName);
                $dataToUpdate['file_cv'] = $fileName;
            }

            $cv->update($dataToUpdate);
            return redirect()->route('pelamar.dashboard')->with('success', 'Profil dan CV Berhasil Diperbarui!');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['sistem_error' => 'Gagal memperbarui CV: ' . $e->getMessage()])
                ->withInput();
        }
    }
}