<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kategori_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode'); // e.g. "PSL1" for Pasal 1
            $table->string('nama'); // e.g. "Pakaian Sekolah"
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('kategori_pelanggaran');
    }
};
