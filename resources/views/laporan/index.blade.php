@extends('layouts.app')
@section('title', 'Laporan')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Laporan Pelanggaran</h1>
        <p class="text-gray-500">Generate dan export laporan pelanggaran</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('laporan.export-excel', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Excel
        </a>
        <a href="{{ route('laporan.export-pdf', request()->query()) }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm flex items-center" target="_blank">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            Export PDF
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="kelas_id" class="px-4 py-2 border rounded-lg text-sm">
            <option value="">Semua Kelas</option>
            @foreach($kelas as $k)
            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
            @endforeach
        </select>
        <select name="bulan" class="px-4 py-2 border rounded-lg text-sm">
            <option value="">Semua Bulan</option>
            @for($i = 1; $i <= 12; $i++)
            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create(null, $i)->translatedFormat('F') }}</option>
            @endfor
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
        <a href="{{ route('laporan.index') }}" class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-50">Reset</a>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">NIS</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Kelas</th>
                    <th class="px-4 py-3 text-left">Pelanggaran</th>
                    <th class="px-4 py-3 text-center">Tingkat</th>
                    <th class="px-4 py-3 text-center">Poin</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggaran as $i => $p)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $pelanggaran->firstItem() + $i }}</td>
                    <td class="px-4 py-3">{{ $p->tanggal_kejadian->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 font-mono">{{ $p->murid->nis }}</td>
                    <td class="px-4 py-3">{{ $p->murid->nama }}</td>
                    <td class="px-4 py-3">{{ $p->murid->kelas->nama }}</td>
                    <td class="px-4 py-3 max-w-xs truncate">{{ $p->jenisPelanggaran->deskripsi }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs {{ $p->jenisPelanggaran->tingkat === 'berat' ? 'bg-red-100 text-red-800' : ($p->jenisPelanggaran->tingkat === 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">{{ ucfirst($p->jenisPelanggaran->tingkat) }}</span>
                    </td>
                    <td class="px-4 py-3 text-center font-bold">{{ $p->poin }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-8 text-center text-gray-500">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">{{ $pelanggaran->links() }}</div>
</div>
@endsection