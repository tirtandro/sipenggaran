@extends('layouts.app')
@section('title', 'Surat Peringatan')
@section('content')
<div x-data="{ 
    showCetakModal: false, 
    cetakUrl: '', 
    namaKepsek: 'Tutik Sunarti, S.Pd., M.Pd.', 
    nipKepsek: '197603182005012003', 
    tanggalCetak: '' 
}">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Surat Peringatan</h1>
        <p class="text-gray-500">Daftar surat peringatan yang telah diterbitkan</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama murid..."
                class="flex-1 px-4 py-2 border rounded-lg text-sm">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Cari</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left">No. Surat</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Murid</th>
                        <th class="px-4 py-3 text-left">Kelas</th>
                        <th class="px-4 py-3 text-center">Jenis</th>
                        <th class="px-4 py-3 text-center">Total Poin</th>
                        <th class="px-4 py-3 text-left">Dibuat Oleh</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratPeringatan as $sp)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-mono text-xs">{{ $sp->nomor_surat }}</td>
                        <td class="px-4 py-3">{{ $sp->tanggal_surat->format('d/m/Y') }}</td>
                        <td class="px-4 py-3"><a href="{{ route('murid.show', $sp->murid) }}" class="text-blue-600 hover:underline">{{ $sp->murid->nama }}</a></td>
                        <td class="px-4 py-3">{{ $sp->murid->kelas->nama }}</td>
                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800 font-bold">{{ $sp->jenis_surat }}</span></td>
                        <td class="px-4 py-3 text-center font-bold">{{ $sp->total_poin }}</td>
                        <td class="px-4 py-3">{{ $sp->pembuat->name }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="#" @click.prevent="cetakUrl = '{{ route('surat.cetak', $sp) }}'; tanggalCetak = '{{ $sp->tanggal_surat->format('Y-m-d') }}'; showCetakModal = true" class="text-blue-600 hover:underline text-xs">Cetak PDF</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-4 py-8 text-center text-gray-500">Belum ada surat peringatan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t">{{ $suratPeringatan->links() }}</div>
    </div>

    <!-- Modal Konfigurasi Cetak PDF -->
    <div x-show="showCetakModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div @click.away="showCetakModal = false" class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Pengaturan Tanda Tangan & Tanggal</h3>
                <button @click="showCetakModal = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kepala Sekolah</label>
                    <input type="text" x-model="namaKepsek" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIP Kepala Sekolah</label>
                    <input type="text" x-model="nipKepsek" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Cetak Surat</label>
                    <input type="date" x-model="tanggalCetak" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" @click="showCetakModal = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm">Batal</button>
                <button type="button" @click="
                    window.open(cetakUrl + '?nama_kepsek=' + encodeURIComponent(namaKepsek) + '&nip_kepsek=' + encodeURIComponent(nipKepsek) + '&tanggal_cetak=' + tanggalCetak, '_blank');
                    showCetakModal = false;
                " class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">Cetak Surat</button>
            </div>
        </div>
    </div>
</div>
@endsection