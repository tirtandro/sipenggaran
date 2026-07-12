<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pelanggaran</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 9pt; margin: 1cm; }
        .header-table { width: 100%; border-bottom: 2px solid #333; padding-bottom: 8px; margin-bottom: 15px; }
        .header-logo { width: 60px; text-align: center; vertical-align: middle; }
        .header-text { text-align: center; vertical-align: middle; }
        .header h2 { margin: 0; font-size: 13pt; font-weight: bold; }
        .header h3 { margin: 3px 0; font-size: 11pt; font-weight: bold; }
        .header p { margin: 1px 0; font-size: 8pt; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 4px 6px; }
        th { background: #e5e7eb; font-weight: bold; text-align: center; }
        td { font-size: 8pt; }
        .footer { margin-top: 15px; font-size: 8pt; color: #555; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="header-logo">
                <img src="{{ public_path('images/logo.png') }}" style="width: 50px; height: auto;">
            </td>
            <td class="header-text">
                <div class="header">
                    <h2>SMA NEGERI 2 WATES</h2>
                    <h3>LAPORAN PELANGGARAN MURID</h3>
                    <p>Tahun Ajaran: {{ $tahunAktif?->nama ?? '-' }} | Kelas: {{ $kelasNama }} | Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
                </div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr><th>No</th><th>Tanggal</th><th>NIS</th><th>Nama</th><th>Kelas</th><th>Pelanggaran</th><th>Tingkat</th><th>Poin</th></tr>
        </thead>
        <tbody>
            @forelse($pelanggaran as $i => $p)
            <tr>
                <td style="text-align:center">{{ $i + 1 }}</td>
                <td>{{ $p->tanggal_kejadian->format('d/m/Y') }}</td>
                <td>{{ $p->murid->nis }}</td>
                <td>{{ $p->murid->nama }}</td>
                <td>{{ $p->murid->kelas->nama }}</td>
                <td>{{ $p->jenisPelanggaran->deskripsi }}</td>
                <td style="text-align:center">{{ ucfirst($p->jenisPelanggaran->tingkat) }}</td>
                <td style="text-align:center">{{ $p->poin }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center">Tidak ada data pelanggaran</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ $pelanggaran->count() }} pelanggaran | Total Poin: {{ $pelanggaran->sum('poin') }}</p>
    </div>
</body>
</html>