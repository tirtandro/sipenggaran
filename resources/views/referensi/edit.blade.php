@extends('layouts.app')
@section('title', 'Edit Jenis Pelanggaran')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Jenis Pelanggaran</h1>
    <p class="text-gray-500">{{ $jenisPelanggaran->kode }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('referensi.update', $jenisPelanggaran) }}">
        @csrf @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode</label>
                <input type="text" name="kode" value="{{ old('kode', $jenisPelanggaran->kode) }}" required class="w-full px-4 py-2 border rounded-lg @error('kode') border-red-500 @enderror">
                @error('kode')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" required class="w-full px-4 py-2 border rounded-lg">{{ old('deskripsi', $jenisPelanggaran->deskripsi) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
                <select name="tingkat" required class="w-full px-4 py-2 border rounded-lg">
                    <option value="ringan" {{ old('tingkat', $jenisPelanggaran->tingkat) == 'ringan' ? 'selected' : '' }}>Ringan</option>
                    <option value="sedang" {{ old('tingkat', $jenisPelanggaran->tingkat) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="berat" {{ old('tingkat', $jenisPelanggaran->tingkat) == 'berat' ? 'selected' : '' }}>Berat</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Poin</label>
                <input type="number" name="poin" value="{{ old('poin', $jenisPelanggaran->poin) }}" min="1" max="100" required class="w-full px-4 py-2 border rounded-lg">
            </div>
        </div>
        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
            <a href="{{ route('referensi.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection