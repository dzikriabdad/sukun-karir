<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Lowongan;
use App\Models\Category;
use App\Models\Experience;
use App\Models\User; // <-- Tambahan untuk Manajemen Admin
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash; // <-- Tambahan untuk enkripsi password Admin

class AdminController extends Controller
{
    // ==========================================
    // 0. DASHBOARD (Statistik Kasar)
    // ==========================================

    public function dashboard()
    {
        $stats = [
            'total_lowongan'   => Lowongan::count(),
            'aktif_lowongan'   => Lowongan::where('status', 'aktif')->count(),
            'total_pelamar'    => Application::count(),
            // 'pending' diubah ke 'screening' menyesuaikan tahapan baru
            'pending_pelamar'  => Application::where('status', 'screening')->count(),
            // 'accepted' diubah ke 'hired' menyesuaikan tahapan baru
            'hired_pelamar'    => Application::where('status', 'hired')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // ==========================================
    // 1. MANAJEMEN LOWONGAN (CRUD)
    // ==========================================

    public function indexLowongan()
    {
        $lowongans = Lowongan::with('category')->latest()->get();
        return view('admin.lowongan.index', compact('lowongans'));
    }

    public function createLowongan()
    {
        $categories = Category::all(); 
        $experiences = Experience::all();
        return view('admin.lowongan.create', compact('categories', 'experiences'));
    }

    public function storeLowongan(Request $request)
    {
        $request->validate([
            'title'               => 'required|string|max:255',
            'category_id'         => 'required|exists:categories,id',
            'experience'          => 'required|string|max:100',
            'penempatan'          => 'required|string|max:255',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'deskripsi'           => 'required|string',
            'persyaratan'         => 'required|string',
            'status'              => 'required|in:aktif,tutup',
            'gambar'              => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_relocation_asked' => 'required|boolean', 
        ]);

        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaGambar = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/loker'), $namaGambar);
        }

        Lowongan::create([
            'user_id'             => Auth::id(),
            'category_id'         => $request->category_id,
            'experience'          => $request->experience,
            'title'               => $request->title,
            'slug'                => Str::slug($request->title), 
            'description'         => $request->deskripsi,   
            'requirements'        => $request->persyaratan, 
            'location'            => $request->penempatan, 
            'deadline'            => $request->end_date,   
            'start_date'          => $request->start_date,
            'status'              => $request->status,
            'gambar'              => $namaGambar,
            'is_relocation_asked' => $request->is_relocation_asked, 
        ]);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil dibuat!');
    }

    public function editLowongan($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $categories = Category::all();
        $experiences = Experience::all();
        return view('admin.lowongan.edit', compact('lowongan', 'categories', 'experiences'));
    }

    public function updateLowongan(Request $request, $id)
    {
        $lowongan = Lowongan::findOrFail($id);
        
        $request->validate([
            'title'               => 'required|string|max:255',
            'category_id'         => 'required|exists:categories,id',
            'experience'          => 'required|string|max:100',
            'penempatan'          => 'required|string|max:255',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date',
            'deskripsi'           => 'required|string',
            'persyaratan'         => 'required|string',
            'status'              => 'required|in:aktif,tutup',
            'is_relocation_asked' => 'required|boolean' 
        ]);

        $lowongan->category_id         = $request->category_id;
        $lowongan->experience          = $request->experience;
        $lowongan->title               = $request->title;
        $lowongan->slug                = Str::slug($request->title); 
        $lowongan->description         = $request->deskripsi;   
        $lowongan->requirements        = $request->persyaratan; 
        $lowongan->location            = $request->penempatan; 
        $lowongan->start_date          = $request->start_date;
        $lowongan->deadline            = $request->end_date;  
        $lowongan->status              = $request->status;
        $lowongan->is_relocation_asked = $request->is_relocation_asked; 

        if ($request->hasFile('gambar')) {
            if ($lowongan->gambar && File::exists(public_path('uploads/loker/' . $lowongan->gambar))) {
                File::delete(public_path('uploads/loker/' . $lowongan->gambar));
            }
            
            $file = $request->file('gambar');
            $namaGambar = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/loker'), $namaGambar);
            $lowongan->gambar = $namaGambar;
        }

        $lowongan->save();

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil diperbarui!');
    }

    public function destroyLowongan($id)
    {
        $lowongan = Lowongan::withCount('applications')->findOrFail($id);

        if ($lowongan->applications_count > 0) {
            return back()->with('error', 'Gagal! Lowongan ini tidak bisa dihapus karena sudah ada pelamar.');
        }

        if ($lowongan->gambar && File::exists(public_path('uploads/loker/' . $lowongan->gambar))) {
            File::delete(public_path('uploads/loker/' . $lowongan->gambar));
        }

        $lowongan->delete();
        return back()->with('success', 'Lowongan berhasil dihapus secara permanen!');
    }

    // ==========================================
    // 2. MANAJEMEN SELEKSI (RECRUITMENT FUNNEL)
    // ==========================================
    
    public function indexApplications(Request $request)
    {
        $lowongans = Lowongan::all(); 
        $query = Application::with(['user', 'lowongan']);

        // 1. Filter by Posisi Lowongan
        if ($request->filled('lowongan_id')) {
            $query->where('lowongan_id', $request->lowongan_id);
        }

        // 2. Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Cari by Nama Pelamar
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $applications = $query->latest()->get();

        return view('admin.applications.index', compact('applications', 'lowongans'));
    }

    /**
     * TAMPILKAN DETAIL LAMARAN + RIWAYAT (JEJAK DIGITAL)
     */
    public function showApplication($id)
    {
        // 1. Ambil data lamaran utama yang sedang dibuka
        $application = Application::with(['user.cv', 'lowongan'])->findOrFail($id);
        
        // 2. LOGIKA RIWAYAT: Ambil semua lamaran LAIN milik user ini
        // Mengambil posisi lamaran lama dan status akhirnya agar HRD bisa memantau
        $history = Application::where('user_id', $application->user_id)
                               ->where('id', '!=', $id) // Kecualikan lamaran yang sedang aktif dibuka
                               ->with('lowongan')
                               ->latest()
                               ->get();
        
        return view('admin.applications.show', compact('application', 'history'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        
        $request->validate([
            'status' => 'required|string'
        ]);

        $application->update(['status' => $request->status]);
        
        return back()->with('success', 'Tahapan seleksi pelamar berhasil diperbarui!');
    }
    
    // ==========================================
    // 3. MASTER DATA
    // ==========================================

    public function indexMaster()
    {
        $categories = Category::all();
        $experiences = Experience::all();
        return view('admin.master.index', compact('categories', 'experiences'));
    }

    public function storeCategory(Request $request) 
    {
        $request->validate(['name' => 'required|string|max:100']);
        Category::create(['name' => $request->name]);
        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function storeExperience(Request $request) 
    {
        $request->validate(['name' => 'required|string|max:100']);
        Experience::create(['name' => $request->name]);
        return back()->with('success', 'Level pengalaman baru berhasil ditambahkan!');
    }

    public function destroyCategory($id) 
    {
        Category::findOrFail($id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }

    public function destroyExperience($id) 
    {
        Experience::findOrFail($id)->delete();
        return back()->with('success', 'Level pengalaman berhasil dihapus!');
    }
    
    // ==========================================
    // 4. MANAJEMEN ADMIN
    // ==========================================

    public function indexAdmin()
    {
        // Mengambil data user yang role-nya 'admin'
        $admins = User::where('role', 'admin')->latest()->get(); 
        return view('admin.users.index', compact('admins'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin', // Sesuaikan jika kamu pakai kolom lain seperti 'is_admin' => 1
        ]);

        return back()->with('success', 'Akun Admin baru berhasil ditambahkan!');
    }

    public function destroyAdmin($id)
    {
        $admin = User::findOrFail($id);
        
        // Proteksi biar admin nggak bisa ngehapus akunnya sendiri pas lagi login
        if ($admin->id == Auth::id()) {
            return back()->with('error', 'Gagal! Kamu tidak bisa menghapus akunmu sendiri.');
        }

        $admin->delete();
        return back()->with('success', 'Akun Admin berhasil dihapus!');
    }
}