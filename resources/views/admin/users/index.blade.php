@extends('layouts.main')

@section('title', 'Admin - Manajemen Akun Admin')

@section('content')
<div class="pt-32 pb-20 px-5 bg-gray-50 min-h-screen">
    <div class="max-w-screen-xl mx-auto">
        
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-blue-900">Manajemen Admin</h1>
            <p class="text-slate-600 mt-2">Tambah atau hapus akses akun HRD / Admin.</p>
        </div>

        {{-- Pesan Sukses / Error --}}
        @if(session('success'))
        <div class="mb-8 p-5 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center shadow-sm">
            <span class="font-bold">{{ session('success') }}</span>
        </div>
        @endif
        @if(session('error'))
        <div class="mb-8 p-5 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center shadow-sm">
            <span class="font-bold">{{ session('error') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOTAK TAMBAH ADMIN KIRI --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                    <h2 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-tight">Tambah Admin Baru</h2>
                    
                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block mb-2 text-xs font-black text-slate-400 uppercase tracking-widest">Nama Lengkap</label>
                            <input type="text" name="name" required class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-black text-slate-400 uppercase tracking-widest">Email</label>
                            <input type="email" name="email" required class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3 focus:ring-blue-500 outline-none">
                            @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-black text-slate-400 uppercase tracking-widest">Password</label>
                            <input type="password" name="password" required minlength="8" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3 focus:ring-blue-500 outline-none">
                        </div>
                        <button type="submit" class="w-full bg-blue-900 text-white font-bold py-3 rounded-xl hover:bg-blue-800 transition shadow-lg shadow-blue-900/20 text-sm">
                            Simpan Akun
                        </button>
                    </form>
                </div>
            </div>

            {{-- TABEL DAFTAR ADMIN KANAN --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left border-collapse min-w-[500px]">
                            <thead>
                                <tr class="bg-blue-900 text-white text-[11px] font-black uppercase tracking-[0.15em]">
                                    <th class="px-8 py-6 whitespace-nowrap">Nama Admin</th>
                                    <th class="px-8 py-6 whitespace-nowrap">Email</th>
                                    <th class="px-8 py-6 text-center whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($admins as $admin)
                                <tr class="hover:bg-blue-50/40 transition">
                                    <td class="px-8 py-6 font-bold text-slate-800 whitespace-nowrap">{{ $admin->name }}</td>
                                    <td class="px-8 py-6 text-sm text-slate-500 whitespace-nowrap">{{ $admin->email }}</td>
                                    <td class="px-8 py-6 text-center">
                                        @if($admin->id !== Auth::id())
                                        <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus admin ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block whitespace-nowrap text-[10px] bg-red-50 hover:bg-red-100 text-red-600 font-black py-2 px-4 rounded-lg transition uppercase tracking-widest">
                                                Hapus
                                            </button>
                                        </form>
                                        @else
                                        <span class="inline-block whitespace-nowrap text-[10px] bg-green-50 text-green-600 font-black py-2 px-4 rounded-lg uppercase tracking-widest">
                                            Sedang Login
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection