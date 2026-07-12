@extends('layouts.app')
@section('title', 'Detail Murid')
@section('content')
<div x-data="{ 
    showCetakModal: false, 
    cetakUrl: '', 
    namaKepsek: 'Tutik Sunarti, S.Pd., M.Pd.', 
    nipKepsek: '197603182005012003', 
    tanggalCetak: '' 
}">
    <div class="mb-6 flex justify-between items-start">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">{{ $murid->nama }}</h1>
        <p class="text-gray-500">{{ $murid->nis }} | {{ $murid->kelas->nama }}</p>
    </div>
    <div class="flex space-x-2">
        @if(auth()->user()->canCatatPelanggaran())
        <a href="{{ route('pelanggaran.create', ['murid_id' => $murid->id]) }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm">Catat Pelanggaran</a>
        @endif
        @if(auth()->user()->isAdmin())
        <a href="{{ route('murid.edit', $murid) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 text-sm">Edit</a>
        @endif
        <a href="{{ route('murid.index') }}" class="border px-4 py-2 rounded-lg hover:bg-gray-50 text-sm">Kembali</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Info Murid -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Informasi Murid</h3>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">NIS</span><span class="font-medium">{{ $murid->nis }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">NISN</span><span class="font-medium">{{ $murid->nisn ?? '-' }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Kelas</span><span class="font-medium">{{ $murid->kelas->nama }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Jenis Kelamin</span><span class="font-medium">{{ $murid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">TTL</span><span class="font-medium">{{ $murid->tempat_lahir }}, {{ $murid->tanggal_lahir?->format('d M Y') }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Alamat</span><span class="font-medium text-right max-w-[60%]">{{ $murid->alamat ?? '-' }}</span></div>
            <hr>
            <div class="flex justify-between"><span class="text-gray-500">Orang Tua/Wali</span><span class="font-medium">{{ $murid->nama_ortu ?? '-' }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">No. HP Ortu</span><span class="font-medium">{{ $murid->no_hp_ortu ?? '-' }}</span></div>
        </div>
    </div>

    <!-- Status Poin -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Status Poin</h3>
        <div class="text-center mb-4">
            <div class="text-5xl font-bold {{ $statusPoin['status'] === 'hijau' ? 'text-green-600' : ($statusPoin['status'] === 'kuning' ? 'text-yellow-600' : ($statusPoin['status'] === 'oranye' ? 'text-orange-600' : 'text-red-600')) }}">
                {{ $totalPoin }}
            </div>
            <p class="text-sm text-gray-500 mt-1">Total Poin</p>
            <span class="inline-block mt-2 px-4 py-1 rounded-full text-sm font-medium {{ $statusPoin['bg'] }}">{{ $statusPoin['label'] }}</span>
        </div>
        <div class="mt-4 space-y-2 text-xs">
            <div class="flex items-center"><span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>0-30: Normal</div>
            <div class="flex items-center"><span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>31-60: Peringatan (SP1)</div>
            <div class="flex items-center"><span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>61-100: Pembinaan Khusus (SP2)</div>
            <div class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>100+: Kritis (SP3)</div>
        </div>
        <!-- Progress bar -->
        <div class="mt-4">
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="h-3 rounded-full {{ $statusPoin['status'] === 'hijau' ? 'bg-green-500' : ($statusPoin['status'] === 'kuning' ? 'bg-yellow-500' : ($statusPoin['status'] === 'oranye' ? 'bg-orange-500' : 'bg-red-500')) }}" style="width: {{ min(100, $totalPoin) }}%"></div>
            </div>
        </div>
    </div>

    <!-- Surat Peringatan -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Surat Peringatan</h3>
        @forelse($murid->suratPeringatan as $sp)
        <div class="p-3 bg-red-50 rounded-lg mb-2">
            <div class="flex justify-between items-start">
                <div>
                    <span class="font-bold text-red-700">{{ $sp->jenis_surat }}</span>
                    <p class="text-xs text-gray-500">{{ $sp->nomor_surat }}</p>
                    <p class="text-xs text-gray-500">{{ $sp->tanggal_surat->format('d M Y') }}</p>
                </div>
                @if(auth()->user()->canCetakSurat())
                <a href="#" @click.prevent="cetakUrl = '{{ route('surat.cetak', $sp) }}'; tanggalCetak = '{{ $sp->tanggal_surat->format('Y-m-d') }}'; showCetakModal = true" class="text-blue-600 hover:underline text-xs">Cetak</a>
                @endif
            </div>
        </div>
        @empty
        <p class="text-gray-500 text-sm text-center">Belum ada surat peringatan</p>
        @endforelse

        @if(auth()->user()->canCetakSurat() && $totalPoin > 30)
        <a href="{{ route('surat.create', ['murid_id' => $murid->id]) }}" class="mt-3 block text-center bg-red-100 text-red-700 px-4 py-2 rounded-lg hover:bg-red-200 text-sm">
            Buat Surat Peringatan
        </a>
        @endif
    </div>
</div>

<!-- Riwayat Pelanggaran -->
<div class="bg-white rounded-xl shadow-sm p-6 mt-6">
    <h3 class="font-semibold text-gray-800 mb-4">Riwayat Pelanggaran</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Tanggal</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Kategori</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Pelanggaran</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Tingkat</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Poin</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Dicatat Oleh</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Sanksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($murid->pelanggaran as $p)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $p->tanggal_kejadian->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ $p->jenisPelanggaran->kategori->nama }}</td>
                    <td class="px-4 py-3">{{ $p->jenisPelanggaran->deskripsi }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs {{ $p->jenisPelanggaran->tingkat === 'berat' ? 'bg-red-100 text-red-800' : ($p->jenisPelanggaran->tingkat === 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($p->jenisPelanggaran->tingkat) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center font-bold">+{{ $p->poin }}</td>
                    <td class="px-4 py-3">{{ $p->pencatat->name }}</td>
                    <td class="px-4 py-3 text-center">
                        @if($p->sanksi)
                            <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">{{ $p->sanksi->jenis_sanksi_label }}</span>
                        @elseif(auth()->user()->canManageSanksi())
                            <a href="{{ route('sanksi.create', ['pelanggaran_id' => $p->id]) }}" class="text-red-600 hover:underline text-xs">Beri Sanksi</a>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada pelanggaran</td></tr>
                @endforelse
            </tbody>
        </table>
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