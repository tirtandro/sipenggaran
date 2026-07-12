@extends('layouts.app')
@section('title', 'Referensi Tata Tertib')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Referensi Tata Tertib</h1>
        <p class="text-gray-500">Daftar jenis pelanggaran berdasarkan Tata Tertib SMAN 2 Wates 2025/2026</p>
    </div>
    @if(auth()->user()->canManageReferensi())
    <a href="{{ route('referensi.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center text-sm font-medium">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Jenis Pelanggaran
    </a>
    @endif
</div>

@foreach($kategori as $kat)
<div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
    <div class="bg-blue-900 text-white px-6 py-3">
        <h3 class="font-semibold">{{ $kat->kode }} - {{ $kat->nama }}</h3>
        <p class="text-blue-200 text-xs">{{ $kat->deskripsi }}</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-2 text-left w-24">Kode</th>
                    <th class="px-4 py-2 text-left">Deskripsi Pelanggaran</th>
                    <th class="px-4 py-2 text-center w-24">Tingkat</th>
                    <th class="px-4 py-2 text-center w-20">Poin</th>
                    @if(auth()->user()->canManageReferensi())
                    <th class="px-4 py-2 text-center w-32">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($kat->jenisPelanggaran as $jp)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2 font-mono text-xs">{{ $jp->kode }}</td>
                    <td class="px-4 py-2">{{ $jp->deskripsi }}</td>
                    <td class="px-4 py-2 text-center">
                        <span class="px-2 py-1 rounded-full text-xs {{ $jp->tingkat === 'berat' ? 'bg-red-100 text-red-800' : ($jp->tingkat === 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">{{ ucfirst($jp->tingkat) }}</span>
                    </td>
                    <td class="px-4 py-2 text-center font-bold">{{ $jp->poin }}</td>
                    @if(auth()->user()->canManageReferensi())
                    <td class="px-4 py-2 text-center space-x-2">
                        <a href="{{ route('referensi.edit', $jp) }}" class="text-blue-600 hover:underline text-xs">Edit</a>
                        <form method="POST" action="{{ route('referensi.destroy', $jp) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis pelanggaran ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-xs">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach
@endsection