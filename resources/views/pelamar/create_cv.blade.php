@extends('layouts.main')

@php
    // Cek apakah variabel $cv ada (berarti sedang mode Edit)
    $isEdit = isset($cv);
@endphp

@section('title', $isEdit ? 'Edit Profil & CV - PT Sukun' : 'Lengkapi Profil - PT Sukun')

@section('content')
<div class="pt-32 pb-20 px-5 bg-neutral-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
        
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm shadow-sm">
                <p class="font-bold mb-1"><i class="bi bi-exclamation-circle-fill mr-2"></i> Mohon periksa kembali:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-8 md:p-12">
                
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                        {{ $isEdit ? 'Edit Profil & CV' : 'Lengkapi Profil' }}
                    </h2>
                    <p class="text-slate-500 mt-2">Pastikan data Anda selalu *up-to-date* untuk peluang karir yang lebih baik.</p>
                </div>

                {{-- FORM ACTION OTOMATIS BERUBAH TERGANTUNG MODE --}}
                <form id="cvForm" action="{{ $isEdit ? route('pelamar.update_cv') : route('pelamar.store_cv') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf
                    
                    {{-- JIKA MODE EDIT, TAMBAHKAN METHOD PUT --}}
                    @if($isEdit)
                        @method('PUT')
                    @endif
                    
                    <input type="hidden" name="identity_number" value="0000000000000000">

                    {{-- SEKSI 1: DATA DIRI --}}
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 bg-blue-900 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">1</div>
                            <h3 class="text-lg font-bold text-slate-800">Informasi Pribadi</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                                <input type="text" value="{{ Auth::user()->name }}" readonly class="w-full px-4 py-3.5 bg-gray-100 border-none rounded-xl text-slate-500 cursor-not-allowed font-medium">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="phone_number">Nomor WhatsApp *</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-gray-200 bg-gray-50 text-slate-500 font-bold text-sm">+62</span>
                                    <input type="number" name="phone_number" id="phone_number" value="{{ old('phone_number', $cv->phone_number ?? '') }}" required placeholder="8123456xxx" class="flex-1 w-full px-4 py-3.5 border border-gray-200 rounded-r-xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tempat Lahir *</label>
                                <input type="text" name="place_of_birth" value="{{ old('place_of_birth', $cv->place_of_birth ?? '') }}" required placeholder="Contoh: Kudus" class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir *</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $cv->date_of_birth ?? '') }}" required class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>

                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Kelamin *</label>
                                    <select name="gender" required class="w-full px-4 py-3.5 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="" disabled {{ !$isEdit ? 'selected' : '' }}>Pilih...</option>
                                        <option value="Laki-laki" {{ old('gender', $cv->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('gender', $cv->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Agama *</label>
                                    <select name="religion" required class="w-full px-4 py-3.5 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                                        @php $agamas = ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya']; @endphp
                                        <option value="" disabled {{ !$isEdit ? 'selected' : '' }}>Pilih...</option>
                                        @foreach($agamas as $agama)
                                            <option value="{{ $agama }}" {{ old('religion', $cv->religion ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Status Kawin *</label>
                                    <select name="marital_status" required class="w-full px-4 py-3.5 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                                        @php $statuses = ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']; @endphp
                                        <option value="" disabled {{ !$isEdit ? 'selected' : '' }}>Pilih Status...</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ old('marital_status', $cv->marital_status ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEKSI 2: PENDIDIKAN --}}
                    <div class="pt-6 border-t border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 bg-blue-900 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">2</div>
                            <h3 class="text-lg font-bold text-slate-800">Riwayat Pendidikan</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Pendidikan Terakhir *</label>
                                <select name="last_education" required class="w-full px-4 py-3.5 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                                    @php $edus = ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1/D4', 'S2', 'S3']; @endphp
                                    <option value="" disabled {{ !$isEdit ? 'selected' : '' }}>Pilih Tingkat...</option>
                                    @foreach($edus as $edu)
                                        <option value="{{ $edu }}" {{ old('last_education', $cv->last_education ?? '') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Instansi / Universitas *</label>
                                <input type="text" name="university" value="{{ old('university', $cv->university ?? '') }}" required placeholder="Contoh: Universitas Muria Kudus" class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Jurusan *</label>
                                <input type="text" name="major" value="{{ old('major', $cv->major ?? '') }}" required placeholder="Contoh: Teknik Informatika" class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">IPK / GPA *</label>
                                <input type="text" name="gpa" value="{{ old('gpa', $cv->gpa ?? '') }}" required placeholder="Contoh: 3.50" class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- SEKSI 3: ALAMAT & PENGALAMAN --}}
                    <div class="pt-6 border-t border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 bg-blue-900 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">3</div>
                            <h3 class="text-lg font-bold text-slate-800">Alamat & Pengalaman</h3>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap (KTP & Domisili) *</label>
                                <textarea name="address" rows="3" required placeholder="Tuliskan alamat lengkap..." class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('address', $cv->address ?? '') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Pengalaman Kerja / Organisasi *</label>
                                <textarea name="experience" rows="4" required placeholder="Ceritakan singkat pengalaman Anda..." class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('experience', $cv->experience ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- SEKSI 4: LAMPIRAN (FILE CV) --}}
                    <div class="pt-6 border-t border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 bg-blue-900 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">4</div>
                            <h3 class="text-lg font-bold text-slate-800">Lampiran Berkas (PDF)</h3>
                        </div>

                        <div class="p-8 bg-blue-50 rounded-[2rem] border-2 border-dashed border-blue-200 text-center relative group hover:bg-blue-100 transition">
                            <svg class="w-12 h-12 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="text-sm font-bold text-blue-900" id="fileNameText">
                                {{ $isEdit ? 'Pilih PDF Baru (Abaikan jika tidak ingin mengganti CV lama)' : 'Klik atau Seret File CV Anda (PDF)' }}
                            </p>
                            @if($isEdit && $cv->file_cv)
                                <p class="text-xs text-green-600 mt-2 font-medium">CV Saat Ini: {{ $cv->file_cv }}</p>
                            @endif
                            
                            {{-- Jika mode edit, file tidak wajib (tidak ada 'required') --}}
                            <input type="file" name="file_cv" id="cvInput" accept=".pdf" {{ $isEdit ? '' : 'required' }} class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </div>
                    </div>

                    {{-- BUTTON SUBMIT --}}
                    <div class="pt-6 flex gap-4">
                        <button type="submit" class="flex-1 bg-blue-900 text-white font-bold py-4 rounded-2xl shadow-lg hover:bg-blue-800 transition flex items-center justify-center gap-2">
                            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Profil Baru' }}
                        </button>
                        <a href="/dashboard" class="px-8 py-4 bg-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-300 transition text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT AUTO-SAVE (LocalStorage) TETAP ADA TAPI HANYA JALAN SAAT CREATE --}}
@if(!$isEdit)
<script>
    const fields = [
        'phone_number', 'place_of_birth', 'date_of_birth', 
        'gender', 'religion', 'marital_status', 
        'last_education', 'university', 'major', 'gpa', 
        'address', 'experience'
    ];
    
    const storageKey = 'sukun_cv_draft_{{ Auth::id() }}';

    window.addEventListener('load', () => {
        const savedData = JSON.parse(localStorage.getItem(storageKey));
        if (savedData) {
            fields.forEach(fieldId => {
                const element = document.getElementsByName(fieldId)[0];
                if (element && savedData[fieldId] && !element.value) {
                    element.value = savedData[fieldId];
                }
            });
        }
    });

    document.addEventListener('input', (e) => {
        if (fields.includes(e.target.name)) {
            const currentData = JSON.parse(localStorage.getItem(storageKey)) || {};
            currentData[e.target.name] = e.target.value;
            localStorage.setItem(storageKey, JSON.stringify(currentData));
        }
    });

    document.getElementById('cvForm').addEventListener('submit', () => {
        setTimeout(() => { localStorage.removeItem(storageKey); }, 1500);
    });
</script>
@endif

<script>
    // Menampilkan Nama File PDF saat diupload
    document.getElementById('cvInput').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const fileName = e.target.files[0].name;
            const displayText = document.getElementById('fileNameText');
            displayText.innerText = "File Terpilih: " + fileName;
            displayText.classList.replace('text-blue-900', 'text-green-600');
        }
    });
</script>
@endsection