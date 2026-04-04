@extends('layouts.main')

@section('title', 'Lamar Pekerjaan - ' . $lowongan->title)

@section('content')
<div class="pt-32 pb-20 px-5 bg-gray-50 min-h-screen">
    <div class="max-w-screen-md mx-auto">
        <h1 class="text-2xl font-bold text-blue-900 mb-8">Formulir Lamaran: {{ $lowongan->title }}</h1>

        {{-- BAGIAN TOA ERROR (Biar kalau mental ketahuan salahnya apa) --}}
        @if ($errors->any())
            <div class="mb-5 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
                <p class="font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    Mohon periksa kembali:
                </p>
                <ul class="list-disc pl-10 mt-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            
            {{-- LOGIKA PENGUNCIAN FORMULIR --}}
            @if(isset($hasActiveApplication) && $hasActiveApplication)
                {{-- JIKA PELAMAR MASIH PUNYA LAMARAN AKTIF --}}
                <div class="text-center py-10">
                    <div class="w-16 h-16 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Lamaran Sedang Diproses</h3>
                    <p class="text-gray-500 mb-8 px-10">Kamu sudah mengirimkan lamaran untuk posisi ini dan saat ini sedang dalam tahap seleksi oleh HRD. Harap bersabar menunggu hasil proses seleksi.</p>
                    
                    <a href="{{ route('pelamar.dashboard') }}" class="inline-block bg-blue-900 text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-800 transition shadow-lg">
                        Cek Status di Dashboard
                    </a>
                </div>
            @else
                {{-- JIKA PELAMAR BELUM DAFTAR / SUDAH DITOLAK (BOLEH MENGISI FORM) --}}
                {{-- PASTIKAN ROUTE DI BAWAH INI SESUAI DENGAN web.php LU --}}
                <form action="{{ route('pelamar.apply.submit', $lowongan->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-bold text-gray-700">Mengapa Anda tertarik melamar posisi ini?</label>
                        <textarea name="application_reason" rows="4" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5 focus:ring-blue-500 focus:border-blue-500" required placeholder="Jelaskan motivasi Anda...">{{ old('application_reason') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-bold text-gray-700">Apa komitmen Anda jika diterima di PT Sukun?</label>
                        <textarea name="commitment" rows="4" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5 focus:ring-blue-500 focus:border-blue-500" required placeholder="Contoh: Saya bersedia bekerja sesuai jadwal dan memberikan kontribusi maksimal...">{{ old('commitment') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">Ekspektasi Gaji (Opsional)</label>
                            <input type="number" name="expected_salary" value="{{ old('expected_salary') }}" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 4000000">
                            <p class="mt-1 text-xs text-gray-500">*Gunakan angka saja tanpa titik/Rp</p>
                        </div>

                        @if($lowongan->is_relocation_asked)
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">Bersedia Ditempatkan di Luar Kota?</label>
                            <select name="relocation_ready" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="1" {{ old('relocation_ready') == '1' ? 'selected' : '' }}>Ya, Bersedia</option>
                                <option value="0" {{ old('relocation_ready') == '0' ? 'selected' : '' }}>Tidak Bersedia</option>
                            </select>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 border-t border-gray-100 pt-8">
                        <button type="submit" class="flex-1 text-white bg-blue-900 hover:bg-blue-800 font-bold rounded-xl text-sm px-5 py-4 transition shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
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