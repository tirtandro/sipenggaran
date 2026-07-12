@extends('layouts.app')
@section('title', 'Buat Surat Peringatan')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Buat Surat Peringatan</h1>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-3xl">
    <div class="mb-6 p-4 bg-yellow-50 rounded-lg">
        <h4 class="font-semibold text-yellow-800">Data Murid:</h4>
        <p class="text-sm mt-1"><strong>{{ $murid->nama }}</strong> ({{ $murid->nis }})</p>
        <p class="text-sm">Kelas: {{ $murid->kelas->nama }} | Total Poin: <strong class="text-red-600">{{ $totalPoin }}</strong></p>
    </div>

    <form method="POST" action="{{ route('surat.store') }}">
        @csrf
        <input type="hidden" name="murid_id" value="{{ $murid->id }}">
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat</label>
                <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $nomorSurat) }}" required class="w-full px-4 py-2 border rounded-lg @error('nomor_surat') border-red-500 @enderror">
                @error('nomor_surat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Surat <span class="text-red-500">*</span></label>
                <select name="jenis_surat" required class="w-full px-4 py-2 border rounded-lg">
                    <option value="SP1" {{ ($jenisSurat ?? '') == 'SP1' ? 'selected' : '' }}>SP1 - Surat Peringatan Pertama</option>
                    <option value="SP2" {{ ($jenisSurat ?? '') == 'SP2' ? 'selected' : '' }}>SP2 - Surat Peringatan Kedua</option>
                    <option value="SP3" {{ ($jenisSurat ?? '') == 'SP3' ? 'selected' : '' }}>SP3 - Surat Peringatan Ketiga</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat</label>
                <input type="date" name="tanggal_surat" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Perihal</label>
                <textarea name="perihal" rows="3" class="w-full px-4 py-2 border rounded-lg">Pemanggilan orang tua/wali murid terkait pelanggaran tata tertib sekolah.</textarea>
            </div>
        </div>
        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
            <a href="{{ route('surat.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">Buat Surat</button>
        </div>
    </form>
</div>
@endsection