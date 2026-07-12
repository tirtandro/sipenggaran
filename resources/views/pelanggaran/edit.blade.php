@extends('layouts.app')
@section('title', 'Edit Pelanggaran')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Data Pelanggaran</h1>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-3xl">
    <form method="POST" action="{{ route('pelanggaran.update', $pelanggaran) }}">
        @csrf @method('PUT')
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Murid <span class="text-red-500">*</span></label>
                <select name="murid_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    @foreach($murid as $m)
                    <option value="{{ $m->id }}" {{ old('murid_id', $pelanggaran->murid_id) == $m->id ? 'selected' : '' }}>{{ $m->nis }} - {{ $m->nama }} ({{ $m->kelas->nama }})</option>
                    @endforeach
                </select>
            </div>

            <div x-data="{ kategoriId: '{{ $pelanggaran->jenisPelanggaran->kategori_id }}', jenisList: @json($pelanggaran->jenisPelanggaran->kategori->jenisPelanggaran), selectedJenis: '{{ $pelanggaran->jenis_pelanggaran_id }}' }">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Pelanggaran</label>
                <select x-model="kategoriId" @change="jenisList = $el.options[$el.selectedIndex].dataset.jenis ? JSON.parse($el.options[$el.selectedIndex].dataset.jenis) : []"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 mb-3">
                    @foreach($kategori as $kat)
                    <option value="{{ $kat->id }}" data-jenis='@json($kat->jenisPelanggaran)' {{ $pelanggaran->jenisPelanggaran->kategori_id == $kat->id ? 'selected' : '' }}>{{ $kat->kode }} - {{ $kat->nama }}</option>
                    @endforeach
                </select>

                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pelanggaran</label>
                <select name="jenis_pelanggaran_id" required x-model="selectedJenis" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <template x-for="jenis in jenisList" :key="jenis.id">
                        <option :value="jenis.id" :selected="jenis.id == selectedJenis" x-text="`[${jenis.kode}] ${jenis.deskripsi} (${jenis.tingkat} - ${jenis.poin} poin)`"></option>
                    </template>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kejadian</label>
                <input type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', $pelanggaran->tanggal_kejadian->format('Y-m-d')) }}" required class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ old('keterangan', $pelanggaran->keterangan) }}</textarea>
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
            <a href="{{ route('pelanggaran.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection