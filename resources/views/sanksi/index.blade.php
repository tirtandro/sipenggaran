@extends('layouts.app')
@section('title', 'Manajemen Sanksi')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Sanksi</h1>
    <p class="text-gray-500">Kelola sanksi pelanggaran murid</p>
</div>

<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form method="GET" class="flex gap-3">
        <select name="status" class="px-4 py-2 border rounded-lg text-sm">
            <option value="">Semua Status</option>
            <option value="belum_dilaksanakan" {{ request('status') == 'belum_dilaksanakan' ? 'selected' : '' }}>Belum Dilaksanakan</option>
            <option value="sedang_berlangsung" {{ request('status') == 'sedang_berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Murid</th>
                    <th class="px-4 py-3 text-left">Kelas</th>
                    <th class="px-4 py-3 text-left">Jenis Sanksi</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-left">Diberikan Oleh</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sanksi as $s)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $s->tanggal_sanksi->format('d/m/Y') }}</td>
                    <td class="px-4 py-3"><a href="{{ route('murid.show', $s->murid) }}" class="text-blue-600 hover:underline">{{ $s->murid->nama }}</a></td>
                    <td class="px-4 py-3">{{ $s->murid->kelas->nama }}</td>
                    <td class="px-4 py-3">{{ $s->jenis_sanksi_label }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs {{ $s->status === 'selesai' ? 'bg-green-100 text-green-800' : ($s->status === 'sedang_berlangsung' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $s->status)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $s->pemberiSanksi->name }}</td>
                    <td class="px-4 py-3 text-center">
                        @if($s->status !== 'selesai')
                        <form method="POST" action="{{ route('sanksi.update-status', $s) }}" class="inline">
                            @csrf @method('PATCH')
                            @if($s->status === 'belum_dilaksanakan')
                            <input type="hidden" name="status" value="sedang_berlangsung">
                            <button type="submit" class="text-yellow-600 hover:underline text-xs">Mulai</button>
                            @else
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="text-green-600 hover:underline text-xs">Selesai</button>
                            @endif
                        </form>
                        @else
                        <span class="text-gray-400 text-xs">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Tidak ada data sanksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">{{ $sanksi->links() }}</div>
</div>
@endsection