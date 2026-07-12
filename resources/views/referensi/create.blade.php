@extends('layouts.app')
@section('title', 'Tambah Jenis Pelanggaran')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Tambah Jenis Pelanggaran</h1>
    <p class="text-gray-500">Tambahkan jenis pelanggaran baru pada tata tertib sekolah</p>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('referensi.store') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Pelanggaran <span class="text-red-500">*</span></label>
                <select name="kategori_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('kategori_id') border-red-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategori as $kat)
                    <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->kode }} - {{ $kat->nama }}</option>
                    @endforeach
                </select>
                @error('kategori_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pelanggaran <span class="text-red-500">*</span></label>
                <input type="text" name="kode" value="{{ old('kode') }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('kode') border-red-500 @enderror" placeholder="Contoh: PSL8-31">
                @error('kode')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Pelanggaran <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="3" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror" placeholder="Tuliskan jenis tindakan pelanggaran...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Pelanggaran <span class="text-red-500">*</span></label>
                <select name="tingkat" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="ringan" {{ old('tingkat') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                    <option value="sedang" {{ old('tingkat') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="berat" {{ old('tingkat') == 'berat' ? 'selected' : '' }}>Berat</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Poin Pelanggaran <span class="text-red-500">*</span></label>
                <input type="number" name="poin" value="{{ old('poin', 5) }}" min="1" max="100" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('poin') border-red-500 @enderror">
                @error('poin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
            <a href="{{ route('referensi.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium">Simpan</button>
        </div>
    </form>
</div>
@endsection