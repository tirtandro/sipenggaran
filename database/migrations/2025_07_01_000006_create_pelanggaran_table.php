<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('murid_id')->constrained('murid')->onDelete('cascade');
            $table->foreignId('jenis_pelanggaran_id')->constrained('jenis_pelanggaran')->onDelete('cascade');
            $table->foreignId('pencatat_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->date('tanggal_kejadian');
            $table->text('keterangan')->nullable();
            $table->string('bukti_foto')->nullable();
            $table->integer('poin');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pelanggaran');
    }
};
