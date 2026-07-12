@extends('layouts.app')
@section('title', 'Catat Pelanggaran')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Catat Pelanggaran Baru</h1>
    <p class="text-gray-500">Isi data pelanggaran murid</p>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-3xl">
    <form method="POST" action="{{ route('pelanggaran.store') }}">
        @csrf
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Murid <span class="text-red-500">*</span></label>
                <select name="murid_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('murid_id') border-red-500 @enderror">
                    <option value="">Pilih Murid</option>
                    @foreach($murid as $m)
                    <option value="{{ $m->id }}" {{ (old('murid_id', $selectedMuridId) == $m->id) ? 'selected' : '' }}>{{ $m->nis }} - {{ $m->nama }} ({{ $m->kelas->nama }})</option>
                    @endforeach
                </select>
                @error('murid_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div x-data="{ kategoriId: '', jenisList: [] }">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Pelanggaran <span class="text-red-500">*</span></label>
                <select x-model="kategoriId" @change="jenisList = $el.options[$el.selectedIndex].dataset.jenis ? JSON.parse($el.options[$el.selectedIndex].dataset.jenis) : []"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 mb-3">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategori as $kat)
                    <option value="{{ $kat->id }}" data-jenis='@json($kat->jenisPelanggaran)'>{{ $kat->kode }} - {{ $kat->nama }}</option>
                    @endforeach
                </select>

                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pelanggaran <span class="text-red-500">*</span></label>
                <select name="jenis_pelanggaran_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('jenis_pelanggaran_id') border-red-500 @enderror">
                    <option value="">Pilih Jenis Pelanggaran</option>
                    <template x-for="jenis in jenisList" :key="jenis.id">
                        <option :value="jenis.id" x-text="`[${jenis.kode}] ${jenis.deskripsi} (${jenis.tingkat} - ${jenis.poin} poin)`"></option>
                    </template>
                </select>
                @error('jenis_pelanggaran_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kejadian <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', date('Y-m-d')) }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                <textarea name="keterangan" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Detail kronologi kejadian...">{{ old('keterangan') }}</textarea>
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
            <a href="{{ route('pelanggaran.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">Catat Pelanggaran</button>
        </div>
    </form>
</div>
@endsection