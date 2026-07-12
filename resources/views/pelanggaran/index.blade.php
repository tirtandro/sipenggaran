@extends('layouts.app')
@section('title', 'Riwayat Pelanggaran')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Pelanggaran</h1>
        <p class="text-gray-500">Data pelanggaran murid SMAN 2 Wates</p>
    </div>
    @if(auth()->user()->canCatatPelanggaran())
    <a href="{{ route('pelanggaran.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Catat Pelanggaran
    </a>
    @endif
</div>

<!-- Filter -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/NIS..."
            class="flex-1 min-w-[180px] px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
        <select name="kelas_id" class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
            <option value="">Semua Kelas</option>
            @foreach($kelas as $k)
            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
            @endforeach
        </select>
        <select name="tingkat" class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
            <option value="">Semua Tingkat</option>
            <option value="ringan" {{ request('tingkat') == 'ringan' ? 'selected' : '' }}>Ringan</option>
            <option value="sedang" {{ request('tingkat') == 'sedang' ? 'selected' : '' }}>Sedang</option>
            <option value="berat" {{ request('tingkat') == 'berat' ? 'selected' : '' }}>Berat</option>
        </select>
        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="px-3 py-2 border rounded-lg text-sm" placeholder="Dari">
        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="px-3 py-2 border rounded-lg text-sm" placeholder="Sampai">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">Filter</button>
        <a href="{{ route('pelanggaran.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm">Reset</a>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Tanggal</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Murid</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Kelas</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Pelanggaran</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Tingkat</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Poin</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Pencatat</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggaran as $p)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $p->tanggal_kejadian->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 font-medium">
                        <a href="{{ route('murid.show', $p->murid) }}" class="text-blue-600 hover:underline">{{ $p->murid->nama }}</a>
                    </td>
                    <td class="px-4 py-3">{{ $p->murid->kelas->nama }}</td>
                    <td class="px-4 py-3 max-w-xs truncate" title="{{ $p->jenisPelanggaran->deskripsi }}">{{ $p->jenisPelanggaran->deskripsi }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs {{ $p->jenisPelanggaran->tingkat === 'berat' ? 'bg-red-100 text-red-800' : ($p->jenisPelanggaran->tingkat === 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($p->jenisPelanggaran->tingkat) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center font-bold text-red-600">+{{ $p->poin }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $p->pencatat->name }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('pelanggaran.show', $p) }}" class="text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @if(auth()->user()->isAdmin() || auth()->user()->id === $p->pencatat_id)
                            <a href="{{ route('pelanggaran.edit', $p) }}" class="text-yellow-600 hover:text-yellow-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-8 text-center text-gray-500">Tidak ada data pelanggaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">{{ $pelanggaran->links() }}</div>
</div>
@endsection