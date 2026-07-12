<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jenis_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_pelanggaran')->onDelete('cascade');
            $table->string('kode');
            $table->text('deskripsi');
            $table->enum('tingkat', ['ringan', 'sedang', 'berat']);
            $table->integer('poin')->default(5);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('jenis_pelanggaran');
    }
};
