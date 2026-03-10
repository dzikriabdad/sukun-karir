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
        $lowongans = Lowongan::with('category')
            ->where('status', 'aktif') 
            ->whereDate('deadline', '>=', Carbon::today()) 
            ->latest()                
            ->take(3)                  
            ->get();

        return view('welcome', compact('lowongans'));
    }

    public function allCareers(Request $request)
    {
        $query = Lowongan::with('category')
            ->where('status', 'aktif') 
            ->whereDate('deadline', '>=', \Carbon\Carbon::today());

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

        // INI TAMBAHANNYA: Ambil data master buat ngisi dropdown!
        $categories = \App\Models\Category::all();
        $experiences = \App\Models\Experience::all();

        // Jangan lupa lempar $categories dan $experiences ke compact
        return view('careers', compact('lowongans', 'categories', 'experiences'));
    }

   public function show($identifier)
    {
        $lowongan = Lowongan::with('category')->where('slug', $identifier)->first();

        if (!$lowongan) {
            $lowongan = Lowongan::with('category')->find($identifier);
        }

        if (!$lowongan) {
            abort(404, 'Maaf, lowongan tidak ditemukan atau link sudah tidak berlaku.');
        }

        // =========================================================================
        // LOGIKA FINAL: Cek apakah user punya lamaran yg SEDANG DIPROSES
        // =========================================================================
        $hasActiveApplication = false;
        
        if (Auth::check() && Auth::user()->role !== 'admin') {
            // Blokir HANYA JIKA statusnya BUKAN rejected. 
            // Kalau udah 'rejected', ini jadi false, dan tombol Lamar NYALA LAGI!
            $hasActiveApplication = Application::where('user_id', Auth::id())
                ->where('lowongan_id', $lowongan->id)
                ->where('status', '!=', 'rejected') 
                ->exists();
        }
        
        if (request()->is('dashboard/*') || request()->is('lowongan/*')) {
            return view('pelamar.show_loker', compact('lowongan', 'hasActiveApplication'));
        }

        return view('detail-career', compact('lowongan', 'hasActiveApplication'));
    }
}