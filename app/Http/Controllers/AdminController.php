<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Lowongan;
use App\Models\Category;
use App\Models\Experience;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ==========================================
    // 0. DASHBOARD
    // ==========================================
    public function dashboard()
    {
        $stats = [
            'total_lowongan'   => Lowongan::count(),
            'aktif_lowongan'   => Lowongan::where('status', 'aktif')->count(),
            'total_pelamar'    => Application::count(),
            'pending_pelamar'  => Application::where('status', 'screening')->count(),
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
    // 2. MANAJEMEN SELEKSI
    // ==========================================
    public function indexApplications(Request $request)
    {
        $lowongans = Lowongan::all(); 
        $query = Application::with(['user', 'lowongan']);

        if ($request->filled('lowongan_id')) {
            $query->where('lowongan_id', $request->lowongan_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $applications = $query->latest()->get();
        return view('admin.applications.index', compact('applications', 'lowongans'));
    }

    public function showApplication($id)
    {
        $application = Application::with(['user.cv', 'lowongan'])->findOrFail($id);
        $history = Application::where('user_id', $application->user_id)
                                ->where('id', '!=', $id)
                                ->with('lowongan')
                                ->latest()
                                ->get();
        
        return view('admin.applications.show', compact('application', 'history'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $request->validate(['status' => 'required|string']);
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
        $request->validate(['name' => 'required|string|max:255']);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Otomatis bikin slug
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function storeExperience(Request $request) 
    {
        $request->validate(['name' => 'required|string|max:100']);

        // JAGA-JAGA: Kalau tabel Experience juga butuh slug, tambahin di sini Bos!
        Experience::create([
            'name' => $request->name,
            // 'slug' => Str::slug($request->name), // Buka comment ini kalau di DB ada kolom slug
        ]);

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
            'role'     => 'admin', 
        ]);

        return back()->with('success', 'Akun Admin baru berhasil ditambahkan!');
    }

    public function destroyAdmin($id)
    {
        $admin = User::findOrFail($id);
        
        if ($admin->id == Auth::id()) {
            return back()->with('error', 'Gagal! Kamu tidak bisa menghapus akunmu sendiri.');
        }

        $admin->delete();
        return back()->with('success', 'Akun Admin berhasil dihapus!');
    }
}