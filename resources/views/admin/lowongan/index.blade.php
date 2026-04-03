@extends('layouts.main')

@section('title', 'Admin - Kelola Lowongan')

@section('content')
<div class="pt-32 pb-20 px-5 bg-gray-50 min-h-screen">
    <div class="max-w-screen-xl mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-5">
            <div>
                <h1 class="text-3xl font-bold text-blue-900">Manajemen Lowongan</h1>
                <p class="text-slate-500 mt-1">Daftar semua posisi pekerjaan yang tersedia di Sukun Karir.</p>
            </div>
            <a href="{{ route('admin.lowongan.create') }}" class="w-full md:w-auto bg-blue-900 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg hover:bg-blue-800 transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Lowongan Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-8 flex items-center gap-3 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-5 text-xs font-bold text-blue-900 uppercase tracking-wider">Info Pekerjaan</th>
                            <th class="px-6 py-5 text-xs font-bold text-blue-900 uppercase tracking-wider">Kategori & Exp</th>
                            <th class="px-6 py-5 text-xs font-bold text-blue-900 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-5 text-xs font-bold text-blue-900 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-5 text-xs font-bold text-blue-900 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($lowongans as $loker)
                        <tr class="hover:bg-slate-50/50 transition duration-200">
                            <td class="px-6 py-5">
                                <div class="font-bold text-slate-900">{{ $loker->title }}</div>
                                <div class="text-xs text-slate-400 mt-0.5 uppercase tracking-tighter italic">Batas: {{ \Carbon\Carbon::parse($loker->deadline)->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="bg-blue-50 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase mr-1">
                                    {{ $loker->category->name ?? 'N/A' }}
                                </span>
                                <span class="bg-purple-50 text-purple-700 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase">
                                    {{ $loker->experience }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-sm text-slate-600">
                                {{ $loker->location ?? '-' }}
                            </td>
                            <td class="px-6 py-5">
                                @if($loker->status == 'aktif')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full"></span>
                                        Tutup
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex justify-center items-center gap-3">
                                    <a href="{{ route('admin.lowongan.edit', $loker->id) }}" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition shadow-sm border border-amber-100" title="Edit Lowongan">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.lowongan.destroy', $loker->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini? Data tidak bisa dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition shadow-sm border border-red-100" title="Hapus Lowongan">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-slate-400 font-medium">Belum ada data lowongan pekerjaan.</p>
                                    <a href="{{ route('admin.lowongan.create') }}" class="text-blue-600 text-sm font-bold mt-2 hover:underline">Tambah Sekarang</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection