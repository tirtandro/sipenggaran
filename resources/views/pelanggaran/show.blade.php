@extends('layouts.app')
@section('title', 'Detail Pelanggaran')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Detail Pelanggaran</h1>
    <a href="{{ route('pelanggaran.index') }}" class="text-blue-600 hover:underline text-sm">Kembali ke daftar</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Informasi Pelanggaran</h3>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">Tanggal</span><span class="font-medium">{{ $pelanggaran->tanggal_kejadian->format('d M Y') }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Kategori</span><span class="font-medium">{{ $pelanggaran->jenisPelanggaran->kategori->nama }}</span></div>
            <div><span class="text-gray-500">Jenis Pelanggaran:</span><p class="font-medium mt-1">{{ $pelanggaran->jenisPelanggaran->deskripsi }}</p></div>
            <div class="flex justify-between"><span class="text-gray-500">Kode</span><span class="font-mono">{{ $pelanggaran->jenisPelanggaran->kode }}</span></div>
            <div class="flex justify-between">
                <span class="text-gray-500">Tingkat</span>
                <span class="px-2 py-1 rounded-full text-xs {{ $pelanggaran->jenisPelanggaran->tingkat === 'berat' ? 'bg-red-100 text-red-800' : ($pelanggaran->jenisPelanggaran->tingkat === 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">{{ ucfirst($pelanggaran->jenisPelanggaran->tingkat) }}</span>
            </div>
            <div class="flex justify-between"><span class="text-gray-500">Poin</span><span class="font-bold text-red-600">+{{ $pelanggaran->poin }}</span></div>
            <hr>
            <div><span class="text-gray-500">Keterangan:</span><p class="mt-1">{{ $pelanggaran->keterangan ?? 'Tidak ada keterangan' }}</p></div>
            <div class="flex justify-between"><span class="text-gray-500">Dicatat oleh</span><span>{{ $pelanggaran->pencatat->name }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Waktu Pencatatan</span><span>{{ $pelanggaran->created_at->format('d M Y H:i') }}</span></div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Data Murid</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Nama</span><a href="{{ route('murid.show', $pelanggaran->murid) }}" class="text-blue-600 hover:underline font-medium">{{ $pelanggaran->murid->nama }}</a></div>
                <div class="flex justify-between"><span class="text-gray-500">NIS</span><span>{{ $pelanggaran->murid->nis }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Kelas</span><span>{{ $pelanggaran->murid->kelas->nama }}</span></div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Sanksi</h3>
            @if($pelanggaran->sanksi)
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Jenis Sanksi</span><span class="font-medium">{{ $pelanggaran->sanksi->jenis_sanksi_label }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Tanggal</span><span>{{ $pelanggaran->sanksi->tanggal_sanksi->format('d M Y') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Status</span>
                    <span class="px-2 py-1 rounded-full text-xs {{ $pelanggaran->sanksi->status === 'selesai' ? 'bg-green-100 text-green-800' : ($pelanggaran->sanksi->status === 'sedang_berlangsung' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $pelanggaran->sanksi->status)) }}
                    </span>
                </div>
                <div><span class="text-gray-500">Deskripsi:</span><p class="mt-1">{{ $pelanggaran->sanksi->deskripsi ?? '-' }}</p></div>
            </div>
            @else
            <p class="text-gray-500 text-sm">Belum ada sanksi diberikan.</p>
            @if(auth()->user()->canManageSanksi())
            <a href="{{ route('sanksi.create', ['pelanggaran_id' => $pelanggaran->id]) }}" class="mt-3 inline-block bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm">Beri Sanksi</a>
            @endif
            @endif
        </div>
    </div>
</div>

<div class="mt-6 flex space-x-3">
    @if(auth()->user()->isAdmin() || auth()->user()->id === $pelanggaran->pencatat_id)
    <a href="{{ route('pelanggaran.edit', $pelanggaran) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 text-sm">Edit</a>
    @endif
    @if(auth()->user()->isAdmin())
    <form method="POST" action="{{ route('pelanggaran.destroy', $pelanggaran) }}" onsubmit="return confirm('Yakin ingin menghapus data pelanggaran ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm">Hapus</button>
    </form>
    @endif
</div>
@endsection