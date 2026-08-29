<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application; 
use App\Models\Lowongan;
use Carbon\Carbon;

class LowonganController extends Controller
{
    public function index(Request $request) 
    {
        // =========================================================================
        // SOURCE DARI HALAMAN UTAMA (GENERAL LINK JOBFAIR)
        // =========================================================================
        if ($request->has('source')) {
            session(['sumber_lamaran' => $request->query('source')]);
            session()->save(); // Paksa simpan ke session
        }
        // =========================================================================

        $lowongans = Lowongan::with('category')
            ->where('status', 'aktif') 
            ->whereDate('deadline', '>=', Carbon::today()) 
            ->latest()                
            ->take(3)                 
            ->get();

        $categories = \App\Models\Category::all();
        $experiences = \App\Models\Experience::all();

        return view('welcome', compact('lowongans', 'categories', 'experiences'));
    }

    public function allCareers(Request $request)
    {
        // Tangkap juga source kalau mereka langsung mendarat di halaman list karir
        if ($request->has('source')) {
            session(['sumber_lamaran' => $request->query('source')]);
            session()->save();
        }

        $query = Lowongan::with('category')
            ->where('status', 'aktif') 
            ->whereDate('deadline', '>=', Carbon::today());

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('experience', $request->kategori);
        }

        if ($request->filled('departemen')) {
            $query->where('category_id', $request->departemen);
        }

        $lowongans = $query->latest()->paginate(6);            
        $lowongans->appends($request->all());

        $categories = \App\Models\Category::all();
        $experiences = \App\Models\Experience::all();

        return view('careers', compact('lowongans', 'categories', 'experiences'));
    }

    public function show(Request $request, $slug)
    {
        // 1. Ambil data lowongan dulu
        $lowongan = Lowongan::with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        // 2. Tangkap parameter 'source' jika ada di URL dan simpan lokasi tujuannya
        if ($request->has('source')) {
            session(['sumber_lamaran' => $request->query('source')]);
            session(['redirect_setelah_login' => route('pelamar.apply', $lowongan->id)]);
            session()->save(); // Paksa simpan data ke session
        }

        // 3. Cek status lamaran aktif pelamar
        $hasActiveApplication = false;
        $isRejected = false; 
        
        if (Auth::check() && Auth::user()->role !== 'admin') {
            $lamaran = Application::where('user_id', Auth::id())
                ->where('lowongan_id', $lowongan->id)
                ->first();

            if ($lamaran) {
                if ($lamaran->status === 'rejected' || $lamaran->status === 'Tolak Lamaran') {
                    $isRejected = true; 
                } else {
                    $hasActiveApplication = true; 
                }
            }
        }
        
        // 4. Cek tenggat waktu lowongan
        $isClosed = $lowongan->status !== 'aktif' || Carbon::parse($lowongan->deadline)->isBefore(Carbon::today());

        if (request()->is('dashboard/*') || request()->is('lowongan/*')) {
            return view('pelamar.show_loker', compact('lowongan', 'hasActiveApplication', 'isRejected', 'isClosed'));
        }

        return view('detail-career', compact('lowongan', 'hasActiveApplication', 'isRejected', 'isClosed'));
    }
}