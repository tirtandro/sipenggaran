@extends('layouts.app')
@section('title', 'Beri Sanksi')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Beri Sanksi</h1>
    <p class="text-gray-500">Berikan sanksi untuk pelanggaran murid</p>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-3xl">
    <div class="mb-6 p-4 bg-red-50 rounded-lg">
        <h4 class="font-semibold text-red-800">Pelanggaran:</h4>
        <p class="text-sm mt-1"><strong>{{ $pelanggaran->murid->nama }}</strong> - {{ $pelanggaran->jenisPelanggaran->deskripsi }}</p>
        <p class="text-xs text-gray-500 mt-1">Poin: +{{ $pelanggaran->poin }} | Tingkat: {{ ucfirst($pelanggaran->jenisPelanggaran->tingkat) }}</p>
    </div>

    <form method="POST" action="{{ route('sanksi.store') }}">
        @csrf
        <input type="hidden" name="pelanggaran_id" value="{{ $pelanggaran->id }}">
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Sanksi <span class="text-red-500">*</span></label>
                <select name="jenis_sanksi" required class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Pilih Sanksi</option>
                    <option value="teguran_lisan">Teguran Lisan</option>
                    <option value="tugas_perbaikan">Tugas Perbaikan</option>
                    <option value="peringatan_tertulis">Peringatan Tertulis</option>
                    <option value="panggil_ortu">Pemanggilan Orang Tua/Wali</option>
                    <option value="pembinaan_khusus">Pembinaan Khusus</option>
                    <option value="diserahkan_pihak_berwajib">Diserahkan Pihak Berwajib</option>
                    <option value="dikembalikan_ke_ortu">Dikembalikan ke Orang Tua/Wali</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sanksi <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_sanksi" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Sanksi</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-lg" placeholder="Detail sanksi yang diberikan..."></textarea>
            </div>
        </div>
        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
            <a href="{{ route('pelanggaran.show', $pelanggaran) }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">Berikan Sanksi</button>
        </div>
    </form>
</div>
@endsection