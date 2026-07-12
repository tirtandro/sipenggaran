@extends('layouts.app')
@section('title', 'Manajemen Tahun Ajaran')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Tahun Ajaran</h1>
        <p class="text-gray-500">Kelola tahun ajaran aktif dan pengarsipan data murid</p>
    </div>
    <div x-data="{ openTambah: false }">
        <button @click="openTambah = true" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Tahun Ajaran
        </button>

        <!-- Modal Tambah -->
        <div x-show="openTambah" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div @click.away="openTambah = false" class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Tambah Tahun Ajaran Baru</h3>
                    <button @click="openTambah = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('tahun-ajaran.store') }}">
                    @csrf
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tahun Ajaran <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 2026/2027">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_mulai" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_selesai" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Salin Kelas Dari</label>
                            <select name="salin_kelas_dari" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">- Template Kelas Default (X A-E, XI A-E, XII A-E) -</option>
                                @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id }}">{{ $ta->nama }} ({{ $ta->kelas_count }} Kelas)</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Menyalin kelas akan menduplikat kelas-kelas dari tahun ajaran yang dipilih.</p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openTambah = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-600">Nama Tahun Ajaran</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-600">Periode</th>
                    <th class="px-6 py-3 text-center font-medium text-gray-600">Jumlah Kelas</th>
                    <th class="px-6 py-3 text-center font-medium text-gray-600">Status</th>
                    <th class="px-6 py-3 text-center font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tahunAjaran as $ta)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $ta->nama }}</td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $ta->tanggal_mulai->format('d M Y') }} s.d {{ $ta->tanggal_selesai->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $ta->kelas_count }} kelas</td>
                    <td class="px-6 py-4 text-center">
                        @if($ta->is_aktif)
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                            Aktif
                        </span>
                        @else
                        <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-800">
                            Terarsip
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if(!$ta->is_aktif)
                        <form method="POST" action="{{ route('tahun-ajaran.aktifkan', $ta) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin mengaktifkan tahun ajaran ini? Tahun ajaran sebelumnya akan otomatis diarsipkan.')">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-3 py-1.5 rounded-lg hover:bg-green-700 text-xs font-semibold">
                                Aktifkan
                            </button>
                        </form>
                        @else
                        <span class="text-xs text-green-700 font-semibold">Sedang Aktif</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection