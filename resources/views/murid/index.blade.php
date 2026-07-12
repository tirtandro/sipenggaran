@extends('layouts.app')
@section('title', 'Data Murid')
@section('content')
<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Data Murid</h1>
        <p class="text-gray-500">Kelola data murid SMAN 2 Wates</p>
    </div>
    @if(auth()->user()->isAdmin())
    <div class="flex flex-wrap items-center gap-2">
        <!-- Download Template -->
        <a href="{{ route('murid.download-template') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm flex items-center border border-gray-300">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Template Excel
        </a>
        
        <!-- Import Excel Button + Hidden Form -->
        <div x-data="{ openImport: false }">
            <button @click="openImport = !openImport" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import Excel
            </button>
            
            <!-- Modal Import -->
            <div x-show="openImport" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div @click.away="openImport = false" class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Import Data Murid</h3>
                        <button @click="openImport = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('murid.import-excel') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" name="file_excel" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 file:hover:bg-blue-100 border rounded-lg p-2">
                        </div>
                        <div class="text-xs text-gray-500 mb-4 bg-gray-50 p-3 rounded-lg">
                            <p class="font-semibold mb-1">Catatan Penting:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Gunakan template Excel yang disediakan.</li>
                                <li>Pastikan nama kelas di Excel terdaftar dan persis sama di sistem.</li>
                                <li>Format tanggal lahir: YYYY-MM-DD.</li>
                            </ul>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="openImport = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm">Batal</button>
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">Proses Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <a href="{{ route('murid.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Murid
        </a>
    </div>
    @endif
</div>

<!-- Filter -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/NIS..."
            class="flex-1 min-w-[200px] px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        <select name="kelas_id" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Kelas</option>
            @foreach($kelas as $k)
            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Cari</button>
        <a href="{{ route('murid.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Reset</a>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">NIS</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Nama</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Kelas</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">L/P</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Total Poin</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($murid as $m)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono">{{ $m->nis }}</td>
                    <td class="px-4 py-3 font-medium">
                        <a href="{{ route('murid.show', $m) }}" class="text-blue-600 hover:underline">{{ $m->nama }}</a>
                    </td>
                    <td class="px-4 py-3">{{ $m->kelas->nama }}</td>
                    <td class="px-4 py-3 text-center">{{ $m->jenis_kelamin }}</td>
                    <td class="px-4 py-3 text-center font-bold">{{ $m->total_poin }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs {{ $m->poin_info['bg'] }}">{{ $m->poin_info['label'] }}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('murid.show', $m) }}" class="text-blue-600 hover:text-blue-800" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @if(auth()->user()->canCatatPelanggaran())
                            <a href="{{ route('pelanggaran.create', ['murid_id' => $m->id]) }}" class="text-red-600 hover:text-red-800" title="Catat Pelanggaran">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </a>
                            @endif
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('murid.edit', $m) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Tidak ada data murid</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">{{ $murid->links() }}</div>
</div>
@endsection