<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Peringatan {{ $surat->nomor_surat }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 11pt; line-height: 1.5; margin: 1cm; }
        .header-table { width: 100%; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header-logo { width: 80px; text-align: center; vertical-align: middle; }
        .header-text { text-align: center; vertical-align: middle; }
        .header h2 { margin: 0; font-size: 13pt; font-weight: bold; }
        .header h3 { margin: 2px 0; font-size: 15pt; font-weight: bold; }
        .header p { margin: 1px 0; font-size: 9pt; }
        .nomor { text-align: center; margin: 20px 0; }
        table.data { width: 100%; border-collapse: collapse; margin: 10px 0; }
        table.data td { padding: 3px 5px; vertical-align: top; }
        table.pelanggaran { width: 100%; border-collapse: collapse; margin: 10px 0; }
        table.pelanggaran th, table.pelanggaran td { border: 1px solid #000; padding: 5px 8px; font-size: 10pt; }
        table.pelanggaran th { background: #f0f0f0; }
        .ttd { margin-top: 40px; text-align: right; }
        .ttd .box { display: inline-block; text-align: center; width: 200px; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="header-logo">
                <img src="{{ public_path('images/logo.png') }}" style="width: 75px; height: auto;">
            </td>
            <td class="header-text">
                <div class="header">
                    <h2>PEMERINTAH DAERAH DAERAH ISTIMEWA YOGYAKARTA</h2>
                    <h2>DINAS PENDIDIKAN, PEMUDA, DAN OLAHRAGA</h2>
                    <h3>SMA NEGERI 2 WATES</h3>
                    <p>Jl. KH. Wahid Hasyim, Bendungan, Wates, Kulon Progo 55651</p>
                    <p>Telp. (0274) 773055 | Email: smadawates@yahoo.co.id | Laman: www.smadawates.sch.id</p>
                </div>
            </td>
        </tr>
    </table>

    <div class="nomor">
        <strong>SURAT PERINGATAN ({{ $surat->jenis_surat }})</strong><br>
        Nomor: {{ $surat->nomor_surat }}
    </div>

    <p>Yang bertanda tangan di bawah ini, Kepala SMA Negeri 2 Wates, dengan ini memberikan <strong>{{ $surat->jenis_surat }}</strong> kepada:</p>

    <table class="data">
        <tr><td width="150">Nama</td><td>: {{ $surat->murid->nama }}</td></tr>
        <tr><td>NIS</td><td>: {{ $surat->murid->nis }}</td></tr>
        <tr><td>Kelas</td><td>: {{ $surat->murid->kelas->nama }}</td></tr>
        <tr><td>Total Poin</td><td>: {{ $surat->total_poin }} poin</td></tr>
    </table>

    <p>Sehubungan dengan pelanggaran tata tertib sekolah yang telah dilakukan, dengan rincian sebagai berikut:</p>

    <table class="pelanggaran">
        <thead>
            <tr><th>No</th><th>Tanggal</th><th>Pelanggaran</th><th>Tingkat</th><th>Poin</th></tr>
        </thead>
        <tbody>
            @foreach($surat->murid->pelanggaran as $i => $p)
            <tr>
                <td style="text-align:center">{{ $i + 1 }}</td>
                <td>{{ $p->tanggal_kejadian->format('d/m/Y') }}</td>
                <td>{{ $p->jenisPelanggaran->deskripsi }}</td>
                <td style="text-align:center">{{ ucfirst($p->jenisPelanggaran->tingkat) }}</td>
                <td style="text-align:center">{{ $p->poin }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>Dengan ini kami meminta kepada orang tua/wali murid yang bersangkutan untuk hadir ke sekolah guna membahas permasalahan ini.</p>
    <p>Demikian surat peringatan ini dibuat untuk dapat ditindaklanjuti sebagaimana mestinya.</p>

    <div class="ttd">
        <div class="box">
            <p>Wates, {{ $tanggalCetak->translatedFormat('d F Y') }}</p>
            <p>Kepala SMAN 2 Wates</p>
            <br><br><br>
            <p><strong><u>{{ $namaKepsek }}</u></strong></p>
            <p style="font-size: 10pt; margin-top: 2px;">NIP. {{ $nipKepsek }}</p>
        </div>
    </div>
</body>
</html>