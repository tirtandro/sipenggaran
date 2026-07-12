<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sanksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggaran_id')->constrained('pelanggaran')->onDelete('cascade');
            $table->foreignId('murid_id')->constrained('murid')->onDelete('cascade');
            $table->enum('jenis_sanksi', ['teguran_lisan', 'tugas_perbaikan', 'peringatan_tertulis', 'panggil_ortu', 'pembinaan_khusus', 'diserahkan_pihak_berwajib', 'dikembalikan_ke_ortu']);
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_sanksi');
            $table->enum('status', ['belum_dilaksanakan', 'sedang_berlangsung', 'selesai'])->default('belum_dilaksanakan');
            $table->foreignId('diberikan_oleh')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('sanksi');
    }
};
