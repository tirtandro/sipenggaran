@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-500">Tahun Ajaran {{ $tahunAktif?->nama ?? '-' }}</p>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Total Murid</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalMurid }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Total Pelanggaran</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalPelanggaran }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Poin Bulan Ini</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalPoinBulanIni }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Status Murid</p>
                <div class="flex space-x-2 mt-1">
                    <span class="px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full">{{ $statusCount['hijau'] }}</span>
                    <span class="px-2 py-0.5 text-xs bg-yellow-100 text-yellow-800 rounded-full">{{ $statusCount['kuning'] }}</span>
                    <span class="px-2 py-0.5 text-xs bg-orange-100 text-orange-800 rounded-full">{{ $statusCount['oranye'] }}</span>
                    <span class="px-2 py-0.5 text-xs bg-red-100 text-red-800 rounded-full">{{ $statusCount['merah'] }}</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tren Pelanggaran 6 Bulan Terakhir</h3>
        <canvas id="chartBulanan" height="200"></canvas>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pelanggaran per Kategori</h3>
        <canvas id="chartKategori" height="200"></canvas>
    </div>
</div>

<!-- Tables Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Murid Bermasalah -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Top 10 Murid Poin Tertinggi</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Kelas</th>
                        <th class="px-4 py-2 text-center">Poin</th>
                        <th class="px-4 py-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($muridBermasalah as $m)
                    <tr class="border-t">
                        <td class="px-4 py-2"><a href="{{ route('murid.show', $m) }}" class="text-blue-600 hover:underline">{{ $m->nama }}</a></td>
                        <td class="px-4 py-2">{{ $m->kelas->nama }}</td>
                        <td class="px-4 py-2 text-center font-bold">{{ $m->total_poin_sum ?? 0 }}</td>
                        <td class="px-4 py-2 text-center">
                            @php $s = app(App\Services\PoinService::class)->getStatusPoin($m->total_poin_sum ?? 0); @endphp
                            <span class="px-2 py-1 rounded-full text-xs {{ $s['bg'] }}">{{ $s['label'] }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pelanggaran Terbaru -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pelanggaran Terbaru</h3>
        <div class="space-y-3">
            @forelse($pelanggaranTerbaru as $p)
            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full {{ $p->jenisPelanggaran->tingkat === 'berat' ? 'bg-red-500' : ($p->jenisPelanggaran->tingkat === 'sedang' ? 'bg-yellow-500' : 'bg-green-500') }}"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800"><a href="{{ route('murid.show', $p->murid) }}" class="hover:underline">{{ $p->murid->nama }}</a> - {{ $p->murid->kelas->nama }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $p->jenisPelanggaran->deskripsi }}</p>
                    <p class="text-xs text-gray-400">{{ $p->tanggal_kejadian->format('d M Y') }} | +{{ $p->poin }} poin</p>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500 text-sm">Belum ada pelanggaran</p>
            @endforelse
        </div>
    </div>
</div>

<script>
// Chart Bulanan
new Chart(document.getElementById('chartBulanan'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(collect($statistikBulanan)->pluck('bulan')) !!},
        datasets: [{
            label: 'Jumlah Pelanggaran',
            data: {!! json_encode(collect($statistikBulanan)->pluck('count')) !!},
            backgroundColor: 'rgba(59, 130, 246, 0.5)',
            borderColor: 'rgb(59, 130, 246)',
            borderWidth: 1
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});

// Chart Kategori
new Chart(document.getElementById('chartKategori'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($statistikKategori->pluck('nama')) !!},
        datasets: [{
            data: {!! json_encode($statistikKategori->pluck('total')) !!},
            backgroundColor: ['#3B82F6','#EF4444','#F59E0B','#10B981','#8B5CF6','#EC4899','#6366F1','#14B8A6']
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } } }
});
</script>
@endsection
