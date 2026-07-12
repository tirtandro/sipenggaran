<?php

namespace Database\Seeders;

use App\Models\KategoriPelanggaran;
use App\Models\JenisPelanggaran;
use Illuminate\Database\Seeder;

class TataTertibSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            [
                'kode' => 'PSL1',
                'nama' => 'Pakaian Sekolah',
                'deskripsi' => 'Pelanggaran terkait pakaian dan seragam sekolah (Pasal 1)',
                'jenis' => [
                    ['kode' => 'PSL1-01', 'deskripsi' => 'Tidak memakai badge OSIS/badge lokasi/badge Pelajar Jogja Bersahabat', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL1-02', 'deskripsi' => 'Tidak memakai kaos kaki putih minimal 10 cm di atas mata kaki', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL1-03', 'deskripsi' => 'Tidak memakai sepatu hitam (dominan hitam)', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL1-04', 'deskripsi' => 'Tidak memakai ikat pinggang warna hitam', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL1-05', 'deskripsi' => 'Tidak memakai seragam sesuai hari yang ditentukan', 'tingkat' => 'ringan', 'poin' => 10],
                    ['kode' => 'PSL1-06', 'deskripsi' => 'Warna jilbab tidak sesuai dengan warna baju', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL1-07', 'deskripsi' => 'Celana/rok tidak sesuai ketentuan (panjang/potongan)', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL1-08', 'deskripsi' => 'Baju tidak dimasukkan ke dalam celana/rok', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL1-09', 'deskripsi' => 'Pakaian terbuat dari kain tipis (transparan) atau ketat', 'tingkat' => 'ringan', 'poin' => 10],
                    ['kode' => 'PSL1-10', 'deskripsi' => 'Tidak memakai seragam olahraga saat berolah raga', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL1-11', 'deskripsi' => 'Tidak memakai sabuk warna hitam', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL1-12', 'deskripsi' => 'Menggunakan jaket di kelas tanpa izin', 'tingkat' => 'ringan', 'poin' => 5],
                ],
            ],
            [
                'kode' => 'PSL2',
                'nama' => 'Rambut, Kuku, Tato, dan Make Up',
                'deskripsi' => 'Pelanggaran terkait penampilan fisik (Pasal 2)',
                'jenis' => [
                    ['kode' => 'PSL2-01', 'deskripsi' => 'Berkuku panjang', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL2-02', 'deskripsi' => 'Mengecat rambut', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL2-03', 'deskripsi' => 'Mengecat kuku', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL2-04', 'deskripsi' => 'Bertato', 'tingkat' => 'berat', 'poin' => 40],
                    ['kode' => 'PSL2-05', 'deskripsi' => 'Murid putra berambut panjang/berkucir', 'tingkat' => 'ringan', 'poin' => 10],
                    ['kode' => 'PSL2-06', 'deskripsi' => 'Murid putra memakai kalung/anting/gelang', 'tingkat' => 'ringan', 'poin' => 10],
                    ['kode' => 'PSL2-07', 'deskripsi' => 'Murid putri memakai make up berlebihan', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL2-08', 'deskripsi' => 'Memakai perhiasan/aksesoris mencolok dan berlebihan', 'tingkat' => 'ringan', 'poin' => 5],
                ],
            ],
            [
                'kode' => 'PSL3',
                'nama' => 'Masuk dan Pulang Sekolah',
                'deskripsi' => 'Pelanggaran terkait kehadiran dan waktu sekolah (Pasal 3)',
                'jenis' => [
                    ['kode' => 'PSL3-01', 'deskripsi' => 'Terlambat datang ke sekolah (setelah 07.00 WIB)', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL3-02', 'deskripsi' => 'Tidak melakukan presensi', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL3-03', 'deskripsi' => 'Terlambat tidak melapor ke guru piket', 'tingkat' => 'ringan', 'poin' => 10],
                    ['kode' => 'PSL3-04', 'deskripsi' => 'Berada di luar kelas tanpa izin guru saat pembelajaran', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL3-05', 'deskripsi' => 'Tidak langsung pulang setelah jam sekolah (tanpa kegiatan resmi)', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL3-06', 'deskripsi' => 'Meninggalkan sekolah pada jam pelajaran tanpa izin', 'tingkat' => 'sedang', 'poin' => 20],
                    ['kode' => 'PSL3-07', 'deskripsi' => 'Masih berada di sekolah setelah pukul 17.00 WIB tanpa kegiatan resmi', 'tingkat' => 'ringan', 'poin' => 10],
                ],
            ],
            [
                'kode' => 'PSL4',
                'nama' => 'Kebersihan, Kedisiplinan dan Ketertiban',
                'deskripsi' => 'Pelanggaran terkait kebersihan dan ketertiban (Pasal 4)',
                'jenis' => [
                    ['kode' => 'PSL4-01', 'deskripsi' => 'Tidak menjaga kebersihan kelas', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL4-02', 'deskripsi' => 'Merusak sarana prasarana/benda di ruang kelas', 'tingkat' => 'sedang', 'poin' => 20],
                    ['kode' => 'PSL4-03', 'deskripsi' => 'Tidak menjaga kebersihan toilet/halaman/lingkungan sekolah', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL4-04', 'deskripsi' => 'Membuang sampah tidak sesuai klasifikasi', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL4-05', 'deskripsi' => 'Tidak merawat tanaman di lingkungan sekolah', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL4-06', 'deskripsi' => 'Makan tidak pada tempatnya (bukan di kantin/ruang makan)', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL4-07', 'deskripsi' => 'Tidak menghemat energi (lampu, kipas, AC menyala tanpa keperluan)', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL4-08', 'deskripsi' => 'Tidak menghemat penggunaan air', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL4-09', 'deskripsi' => 'Tidak budaya antre', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL4-10', 'deskripsi' => 'Mengganggu suasana ketenangan belajar', 'tingkat' => 'ringan', 'poin' => 10],
                    ['kode' => 'PSL4-11', 'deskripsi' => 'Tidak menaati jadwal kegiatan sekolah', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL4-12', 'deskripsi' => 'Tidak menyelesaikan tugas sekolah sesuai ketentuan', 'tingkat' => 'ringan', 'poin' => 5],
                ],
            ],
            [
                'kode' => 'PSL5',
                'nama' => 'Sopan Santun Pergaulan',
                'deskripsi' => 'Pelanggaran terkait sopan santun dalam pergaulan (Pasal 5)',
                'jenis' => [
                    ['kode' => 'PSL5-01', 'deskripsi' => 'Tidak menghormati guru/karyawan/tamu sekolah', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL5-02', 'deskripsi' => 'Tidak menghormati hak cipta dan hak milik teman/warga sekolah', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL5-03', 'deskripsi' => 'Menggunakan panggilan yang tidak sopan', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL5-04', 'deskripsi' => 'Menyampaikan pendapat dengan menyinggung perasaan orang lain', 'tingkat' => 'ringan', 'poin' => 10],
                    ['kode' => 'PSL5-05', 'deskripsi' => 'Menggunakan bahasa/kata-kata tidak sopan saat berkomunikasi', 'tingkat' => 'sedang', 'poin' => 15],
                ],
            ],
            [
                'kode' => 'PSL6',
                'nama' => 'Upacara Bendera dan Hari Besar',
                'deskripsi' => 'Pelanggaran terkait upacara bendera dan peringatan hari besar (Pasal 6)',
                'jenis' => [
                    ['kode' => 'PSL6-01', 'deskripsi' => 'Tidak mengikuti upacara bendera hari Senin tanpa keterangan', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL6-02', 'deskripsi' => 'Tidak memakai seragam upacara sesuai ketentuan', 'tingkat' => 'ringan', 'poin' => 10],
                    ['kode' => 'PSL6-03', 'deskripsi' => 'Tidak berada di barisan kelas saat upacara', 'tingkat' => 'ringan', 'poin' => 10],
                    ['kode' => 'PSL6-04', 'deskripsi' => 'Tidak mengikuti upacara Hari Besar Nasional', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL6-05', 'deskripsi' => 'Tidak mengikuti kegiatan hari besar keagamaan di sekolah', 'tingkat' => 'sedang', 'poin' => 15],
                ],
            ],
            [
                'kode' => 'PSL7',
                'nama' => 'Kegiatan Keagamaan',
                'deskripsi' => 'Pelanggaran terkait kegiatan keagamaan (Pasal 7)',
                'jenis' => [
                    ['kode' => 'PSL7-01', 'deskripsi' => 'Tidak menjalankan shalat Dhuhur/Jumat berjamaah di sekolah (muslim)', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL7-02', 'deskripsi' => 'Tidak mengikuti pengajian/pesantren Ramadhan di sekolah (muslim)', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL7-03', 'deskripsi' => 'Tidak mengikuti PPK/misa pelajar (Kristen/Katolik)', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL7-04', 'deskripsi' => 'Melakukan kegiatan keagamaan tanpa sepengetahuan sekolah', 'tingkat' => 'ringan', 'poin' => 10],
                ],
            ],
            [
                'kode' => 'PSL8',
                'nama' => 'Larangan-larangan',
                'deskripsi' => 'Pelanggaran terhadap larangan-larangan (Pasal 8)',
                'jenis' => [
                    ['kode' => 'PSL8-01', 'deskripsi' => 'Merokok di lingkungan sekolah', 'tingkat' => 'berat', 'poin' => 50],
                    ['kode' => 'PSL8-02', 'deskripsi' => 'Minum-minuman keras', 'tingkat' => 'berat', 'poin' => 75],
                    ['kode' => 'PSL8-03', 'deskripsi' => 'Mengedarkan/mengkonsumsi narkotika/psikotropika/obat terlarang', 'tingkat' => 'berat', 'poin' => 100],
                    ['kode' => 'PSL8-04', 'deskripsi' => 'Berkelahi perorangan di dalam/luar sekolah', 'tingkat' => 'berat', 'poin' => 50],
                    ['kode' => 'PSL8-05', 'deskripsi' => 'Berkelahi kelompok di dalam/luar sekolah', 'tingkat' => 'berat', 'poin' => 75],
                    ['kode' => 'PSL8-06', 'deskripsi' => 'Melakukan perundungan/bullying verbal', 'tingkat' => 'berat', 'poin' => 40],
                    ['kode' => 'PSL8-07', 'deskripsi' => 'Melakukan perundungan/bullying fisik', 'tingkat' => 'berat', 'poin' => 60],
                    ['kode' => 'PSL8-08', 'deskripsi' => 'Melakukan perundungan/bullying siber/media sosial', 'tingkat' => 'berat', 'poin' => 50],
                    ['kode' => 'PSL8-09', 'deskripsi' => 'Berpacaran di lingkungan sekolah', 'tingkat' => 'sedang', 'poin' => 20],
                    ['kode' => 'PSL8-10', 'deskripsi' => 'Membuang sampah tidak pada tempatnya', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL8-11', 'deskripsi' => 'Mencoret-coret meja/bangku/dinding/pagar/sarana sekolah', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL8-12', 'deskripsi' => 'Berbicara kotor/mengumpat/menghina/sapaan tidak senonoh', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL8-13', 'deskripsi' => 'Membawa senjata/alat yang membahayakan keselamatan', 'tingkat' => 'berat', 'poin' => 75],
                    ['kode' => 'PSL8-14', 'deskripsi' => 'Membawa/membaca/mengedarkan konten pornografi', 'tingkat' => 'berat', 'poin' => 60],
                    ['kode' => 'PSL8-15', 'deskripsi' => 'Membawa kartu dan bermain judi di lingkungan sekolah', 'tingkat' => 'berat', 'poin' => 40],
                    ['kode' => 'PSL8-16', 'deskripsi' => 'Mencuri/mengambil barang milik orang lain', 'tingkat' => 'berat', 'poin' => 60],
                    ['kode' => 'PSL8-17', 'deskripsi' => 'Meninggalkan sekolah pada jam pelajaran tanpa izin', 'tingkat' => 'sedang', 'poin' => 20],
                    ['kode' => 'PSL8-18', 'deskripsi' => 'Merusak sarana prasarana milik sekolah', 'tingkat' => 'sedang', 'poin' => 25],
                    ['kode' => 'PSL8-19', 'deskripsi' => 'Melakukan perbuatan tidak senonoh/asusila/perzinaan', 'tingkat' => 'berat', 'poin' => 100],
                    ['kode' => 'PSL8-20', 'deskripsi' => 'Mengambil gambar tidak pantas dan menyebarluaskan', 'tingkat' => 'berat', 'poin' => 60],
                    ['kode' => 'PSL8-21', 'deskripsi' => 'Membuat geng/kelompok berpotensi kegiatan negatif', 'tingkat' => 'berat', 'poin' => 40],
                    ['kode' => 'PSL8-22', 'deskripsi' => 'Memakai kendaraan bermotor perlengkapan tidak standar', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL8-23', 'deskripsi' => 'Memakai kendaraan bermotor knalpot tidak standar (blombongan)', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL8-24', 'deskripsi' => 'Menggunakan piring/gelas/sendok/sedotan plastik sekali pakai', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL8-25', 'deskripsi' => 'Membawa peralatan makan/minum kantin ke ruang belajar', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL8-26', 'deskripsi' => 'Membuang sampah di laci meja', 'tingkat' => 'ringan', 'poin' => 5],
                    ['kode' => 'PSL8-27', 'deskripsi' => 'Mengancam/mengintimidasi/meminta sesuatu dengan paksa', 'tingkat' => 'berat', 'poin' => 50],
                    ['kode' => 'PSL8-28', 'deskripsi' => 'Bermain/olahraga pada jam pelajaran selain olahraga tanpa izin', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL8-29', 'deskripsi' => 'Kegiatan lebih dari pukul 17.00 tanpa izin Kepala Sekolah', 'tingkat' => 'sedang', 'poin' => 15],
                    ['kode' => 'PSL8-30', 'deskripsi' => 'Melakukan hal yang mencemarkan nama baik SMAN 2 Wates', 'tingkat' => 'berat', 'poin' => 75],
                ],
            ],
        ];

        foreach ($kategori as $kat) {
            $jenisList = $kat['jenis'];
            unset($kat['jenis']);

            $kategoriModel = KategoriPelanggaran::create($kat);

            foreach ($jenisList as $jenis) {
                $jenis['kategori_id'] = $kategoriModel->id;
                JenisPelanggaran::create($jenis);
            }
        }
    }
}
