<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicantDetail;
use Illuminate\Support\Facades\Auth;

class ApplicantDetailController extends Controller
{
    // Nampilin halaman form biodata
    public function create()
    {
        // Kalau pelamar udah ngisi data, langsung lempar ke halaman lain biar nggak ngisi 2x
        if (Auth::user()->detail) {
            return redirect('/dashboard')->with('info', 'Biodata kamu sudah lengkap!');
        }
        
        return view('applicant.detail-form');
    }

    // Nyimpen data dan file upload dari form
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|max:16',
            'phone_number' => 'required|max:15',
            'address' => 'required',
            'cv' => 'required|mimes:pdf|max:2048', // CV Wajib PDF dan maksimal 2MB
        ]);

        // Proses simpan file CV ke folder storage/app/public/cv_pelamar
        $cvPath = $request->file('cv')->store('cv_pelamar', 'public');

        ApplicantDetail::create([
            'user_id' => Auth::id(),
            'nik' => $request->nik,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'last_education' => $request->last_education,
            'cv_path' => $cvPath,
        ]);

        return redirect('/dashboard')->with('success', 'Biodata berhasil disimpan!');
    }
}