@extends('layouts.main')

@section('title', 'Admin - Edit Lowongan')

@section('content')
<div class="pt-32 pb-20 px-5 bg-gray-50 min-h-screen">
    <div class="max-w-screen-md mx-auto">
        <h1 class="text-2xl font-bold text-blue-900 mb-8">Edit Lowongan Kerja</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-2xl">
                <p class="font-bold">Gagal Simpan! Mohon perbaiki kesalahan berikut:</p>
                <ul class="list-disc list-inside text-sm mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.lowongan.update', $lowongan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-bold text-gray-700">Nama Posisi / Pekerjaan</label>
                    <input type="text" name="title" value="{{ old('title', $lowongan->title) }}" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Level Pengalaman</label>
                        <select name="experience" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required>
                            @foreach($experiences as $exp)
                                <option value="{{ $exp->name }}" {{ old('experience', $lowongan->experience) == $exp->name ? 'selected' : '' }}>{{ $exp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Kategori Pekerjaan</label>
                        <select name="category_id" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $lowongan->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-bold text-gray-700">Lokasi Penempatan</label>
                    <input type="text" name="penempatan" value="{{ old('penempatan', $lowongan->location) }}" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required>
                </div>

                <div class="mb-6 p-4 bg-blue-50 rounded-2xl border border-blue-100">
                    <label class="block mb-2 text-sm font-bold text-blue-900">Tanyakan Kesiapan Relokasi ke Pelamar?</label>
                    <select name="is_relocation_asked" class="bg-white border border-blue-200 text-sm rounded-xl block w-full p-3.5" required>
                        <option value="1" {{ old('is_relocation_asked', $lowongan->is_relocation_asked) == 1 ? 'selected' : '' }}>Ya, Tanyakan</option>
                        <option value="0" {{ old('is_relocation_asked', $lowongan->is_relocation_asked) == 0 ? 'selected' : '' }}>Tidak Perlu</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $lowongan->start_date) }}" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Tanggal Selesai (Deadline)</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $lowongan->deadline) }}" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-bold text-gray-700">Deskripsi Pekerjaan</label>
                    <textarea name="deskripsi" rows="5" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required>{{ old('deskripsi', $lowongan->description) }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-bold text-gray-700">Persyaratan</label>
                    <textarea name="persyaratan" rows="5" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required>{{ old('persyaratan', $lowongan->requirements) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Status Lowongan</label>
                        <select name="status" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required>
                            <option value="aktif" {{ old('status', $lowongan->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tutup" {{ old('status', $lowongan->status) == 'tutup' ? 'selected' : '' }}>Tutup</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Ganti Banner (Opsional)</label>
                        <input type="file" name="gambar" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-2.5">
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 text-white bg-blue-900 hover:bg-blue-800 font-bold rounded-xl text-sm px-5 py-4 transition shadow-lg">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.lowongan.index') }}" class="px-8 py-4 bg-gray-200 text-gray-700 font-bold rounded-xl text-sm hover:bg-gray-300 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection