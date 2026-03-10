@extends('layouts.main')

@section('title', 'Lamar Pekerjaan - ' . $lowongan->title)

@section('content')
<div class="pt-32 pb-20 px-5 bg-gray-50 min-h-screen">
    <div class="max-w-screen-md mx-auto">
        <h1 class="text-2xl font-bold text-blue-900 mb-8">Formulir Lamaran: {{ $lowongan->title }}</h1>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            
            {{-- LOGIKA PENGUNCIAN FORMULIR --}}
            @if(isset($hasActiveApplication) && $hasActiveApplication)
                {{-- JIKA PELAMAR MASIH PUNYA LAMARAN AKTIF --}}
                <div class="text-center py-10">
                    <div class="w-16 h-16 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Lamaran Sedang Diproses</h3>
                    <p class="text-gray-500 mb-8">Kamu sudah mengirimkan lamaran untuk posisi ini dan saat ini sedang dalam tahap seleksi oleh HRD. Harap bersabar menunggu hasil proses seleksi.</p>
                    
                    <a href="{{ route('pelamar.dashboard') }}" class="inline-block bg-blue-900 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-800 transition shadow-lg">
                        Cek Status di Dashboard
                    </a>
                </div>
            @else
                {{-- JIKA PELAMAR BELUM DAFTAR / SUDAH DITOLAK (BOLEH MENGISI FORM) --}}
                <form action="{{ route('pelamar.store', $lowongan->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-bold text-gray-700">Mengapa Anda tertarik melamar posisi ini?</label>
                        <textarea name="application_reason" rows="4" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required placeholder="Jelaskan motivasi Anda..."></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-bold text-gray-700">Apa komitmen Anda jika diterima di PT Sukun?</label>
                        <textarea name="commitment" rows="4" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required placeholder="Contoh: Saya bersedia bekerja sesuai jadwal..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">Ekspektasi Gaji (Opsional)</label>
                            <input type="number" name="expected_salary" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" placeholder="Contoh: 4000000">
                            <p class="mt-1 text-xs text-gray-500">*Kosongkan jika ingin negosiasi</p>
                        </div>

                        @if($lowongan->is_relocation_asked)
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">Bersedia Ditempatkan di Luar Kota?</label>
                            <select name="relocation_ready" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required>
                                <option value="1">Ya, Bersedia</option>
                                <option value="0">Tidak Bersedia</option>
                            </select>
                        </div>
                        @endif
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 text-white bg-blue-900 hover:bg-blue-800 font-bold rounded-xl text-sm px-5 py-4 transition shadow-lg">
                            Kirim Lamaran Sekarang
                        </button>
                        <a href="{{ route('career.detail', $lowongan->id) }}" class="px-8 py-4 bg-gray-200 text-gray-700 font-bold rounded-xl text-sm hover:bg-gray-300 transition text-center">
                            Batal
                        </a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection