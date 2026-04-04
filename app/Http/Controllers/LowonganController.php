<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application; 
use App\Models\Lowongan;
use Carbon\Carbon;

class LowonganController extends Controller
{
    public function index() 
    {
        // 1. Ambil 3 lowongan terbaru untuk ditampilkan di beranda
        $lowongans = Lowongan::with('category')
            ->where('status', 'aktif') 
            ->whereDate('deadline', '>=', Carbon::today()) 
            ->latest()                
            ->take(3)                  
            ->get();

        // 2. Ambil data master buat ngisi dropdown pencarian
        $categories = \App\Models\Category::all();
        $experiences = \App\Models\Experience::all();

        // 3. Lempar datanya ke view welcome
        return view('welcome', compact('lowongans', 'categories', 'experiences'));
    }

    public function allCareers(Request $request)
    {
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

        // Ambil data master buat dropdown filter
        $categories = \App\Models\Category::all();
        $experiences = \App\Models\Experience::all();

        return view('careers', compact('lowongans', 'categories', 'experiences'));
    }

    public function show($slug)
    {
        // =========================================================================
        // LOGIKA BARU: Cuma cari berdasarkan SLUG (Tanpa filter aktif/deadline)
        // Biar kalau loker ditutup, halamannya tetep kebuka dan gak 404 Not Found
        // =========================================================================
        $lowongan = Lowongan::with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        // =========================================================================
        // LOGIKA CEK STATUS PELAMAR
        // =========================================================================
        $hasActiveApplication = false;
        $isRejected = false; 
        
        if (Auth::check() && Auth::user()->role !== 'admin') {
            $lamaran = Application::where('user_id', Auth::id())
                ->where('lowongan_id', $lowongan->id)
                ->first();

            if ($lamaran) {
                // Cek apakah lamaran ditolak
                if ($lamaran->status === 'rejected' || $lamaran->status === 'Tolak Lamaran') {
                    $isRejected = true; 
                } else {
                    $hasActiveApplication = true; 
                }
            }
        }
        
        // =========================================================================
        // CEK APAKAH LOWONGAN SUDAH DITUTUP (Buat ngatur tombol di View)
        // =========================================================================
        $isClosed = $lowongan->status !== 'aktif' || Carbon::parse($lowongan->deadline)->isBefore(Carbon::today());

        // Cek darimana request berasal (Halaman Pelamar atau Publik)
        if (request()->is('dashboard/*') || request()->is('lowongan/*')) {
            return view('pelamar.show_loker', compact('lowongan', 'hasActiveApplication', 'isRejected', 'isClosed'));
        }

        return view('detail-career', compact('lowongan', 'hasActiveApplication', 'isRejected', 'isClosed'));
    }
}