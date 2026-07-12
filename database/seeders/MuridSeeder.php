<?php

namespace Database\Seeders;

use App\Models\Murid;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class MuridSeeder extends Seeder
{
    public function run(): void
    {
        $namaPutra = ['Ahmad Rizki', 'Budi Prasetyo', 'Cahyo Wibowo', 'Dani Setiawan', 'Eko Saputra', 'Farhan Maulana', 'Galih Pratama', 'Hendra Kurniawan', 'Irfan Hakim', 'Joko Susilo'];
        $namaPutri = ['Ayu Lestari', 'Bunga Citra', 'Citra Dewi', 'Dina Safitri', 'Endah Wulandari', 'Fitri Handayani', 'Gita Savitri', 'Hani Rahmawati', 'Indah Permata', 'Jasmine Putri'];

        $kelas = Kelas::all();
        $counter = 1;

        foreach ($kelas as $k) {
            // 5 murid per kelas for demo
            for ($i = 0; $i < 3; $i++) {
                $idx = ($counter + $i) % count($namaPutra);
                Murid::create([
                    'nis' => '2025' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                    'nisn' => '00' . str_pad($counter, 8, '0', STR_PAD_LEFT),
                    'nama' => $namaPutra[$idx],
                    'jenis_kelamin' => 'L',
                    'kelas_id' => $k->id,
                    'tempat_lahir' => 'Kulon Progo',
                    'tanggal_lahir' => '2008-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                    'alamat' => 'Wates, Kulon Progo',
                    'nama_ortu' => 'Bapak ' . $namaPutra[$idx],
                    'no_hp_ortu' => '08' . rand(1000000000, 9999999999),
                ]);
                $counter++;
            }
            for ($i = 0; $i < 2; $i++) {
                $idx = ($counter + $i) % count($namaPutri);
                Murid::create([
                    'nis' => '2025' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                    'nisn' => '00' . str_pad($counter, 8, '0', STR_PAD_LEFT),
                    'nama' => $namaPutri[$idx],
                    'jenis_kelamin' => 'P',
                    'kelas_id' => $k->id,
                    'tempat_lahir' => 'Kulon Progo',
                    'tanggal_lahir' => '2008-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                    'alamat' => 'Wates, Kulon Progo',
                    'nama_ortu' => 'Ibu ' . $namaPutri[$idx],
                    'no_hp_ortu' => '08' . rand(1000000000, 9999999999),
                ]);
                $counter++;
            }
        }
    }
}
