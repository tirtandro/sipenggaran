CREATE TABLE "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "role" varchar check("role" in('admin', 'guru_bk', 'guru_piket', 'wali_kelas')) not null default 'guru_piket',
  "kelas_id" integer,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE INDEX "cache_expiration_index" on "cache"("expiration");
CREATE TABLE "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE INDEX "cache_locks_expiration_index" on "cache_locks"("expiration");
CREATE TABLE "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE "tahun_ajaran"(
  "id" integer primary key autoincrement not null,
  "nama" varchar not null,
  "tanggal_mulai" date not null,
  "tanggal_selesai" date not null,
  "is_aktif" tinyint(1) not null default '0',
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE "kelas"(
  "id" integer primary key autoincrement not null,
  "nama" varchar not null,
  "tingkat" varchar check("tingkat" in('X', 'XI', 'XII')) not null,
  "jurusan" varchar,
  "tahun_ajaran_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("tahun_ajaran_id") references "tahun_ajaran"("id") on delete cascade
);
CREATE TABLE "murid"(
  "id" integer primary key autoincrement not null,
  "nis" varchar not null,
  "nisn" varchar,
  "nama" varchar not null,
  "jenis_kelamin" varchar check("jenis_kelamin" in('L', 'P')) not null,
  "kelas_id" integer not null,
  "tempat_lahir" varchar,
  "tanggal_lahir" date,
  "alamat" text,
  "nama_ortu" varchar,
  "no_hp_ortu" varchar,
  "foto" varchar,
  "is_aktif" tinyint(1) not null default '1',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("kelas_id") references "kelas"("id") on delete cascade
);
CREATE UNIQUE INDEX "murid_nis_unique" on "murid"("nis");
CREATE TABLE "kategori_pelanggaran"(
  "id" integer primary key autoincrement not null,
  "kode" varchar not null,
  "nama" varchar not null,
  "deskripsi" text,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE "jenis_pelanggaran"(
  "id" integer primary key autoincrement not null,
  "kategori_id" integer not null,
  "kode" varchar not null,
  "deskripsi" text not null,
  "tingkat" varchar check("tingkat" in('ringan', 'sedang', 'berat')) not null,
  "poin" integer not null default '5',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("kategori_id") references "kategori_pelanggaran"("id") on delete cascade
);
CREATE TABLE "pelanggaran"(
  "id" integer primary key autoincrement not null,
  "murid_id" integer not null,
  "jenis_pelanggaran_id" integer not null,
  "pencatat_id" integer not null,
  "tahun_ajaran_id" integer not null,
  "tanggal_kejadian" date not null,
  "keterangan" text,
  "bukti_foto" varchar,
  "poin" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("murid_id") references "murid"("id") on delete cascade,
  foreign key("jenis_pelanggaran_id") references "jenis_pelanggaran"("id") on delete cascade,
  foreign key("pencatat_id") references "users"("id") on delete cascade,
  foreign key("tahun_ajaran_id") references "tahun_ajaran"("id") on delete cascade
);
CREATE TABLE "sanksi"(
  "id" integer primary key autoincrement not null,
  "pelanggaran_id" integer not null,
  "murid_id" integer not null,
  "jenis_sanksi" varchar check("jenis_sanksi" in('teguran_lisan', 'tugas_perbaikan', 'peringatan_tertulis', 'panggil_ortu', 'pembinaan_khusus', 'diserahkan_pihak_berwajib', 'dikembalikan_ke_ortu')) not null,
  "deskripsi" text,
  "tanggal_sanksi" date not null,
  "status" varchar check("status" in('belum_dilaksanakan', 'sedang_berlangsung', 'selesai')) not null default 'belum_dilaksanakan',
  "diberikan_oleh" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("pelanggaran_id") references "pelanggaran"("id") on delete cascade,
  foreign key("murid_id") references "murid"("id") on delete cascade,
  foreign key("diberikan_oleh") references "users"("id") on delete cascade
);
CREATE TABLE "surat_peringatan"(
  "id" integer primary key autoincrement not null,
  "nomor_surat" varchar not null,
  "murid_id" integer not null,
  "tahun_ajaran_id" integer not null,
  "jenis_surat" varchar check("jenis_surat" in('SP1', 'SP2', 'SP3')) not null,
  "total_poin" integer not null,
  "tanggal_surat" date not null,
  "perihal" text,
  "dibuat_oleh" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("murid_id") references "murid"("id") on delete cascade,
  foreign key("tahun_ajaran_id") references "tahun_ajaran"("id") on delete cascade,
  foreign key("dibuat_oleh") references "users"("id") on delete cascade
);
CREATE UNIQUE INDEX "surat_peringatan_nomor_surat_unique" on "surat_peringatan"(
  "nomor_surat"
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2025_07_01_000001_create_tahun_ajaran_table',1);
INSERT INTO migrations VALUES(5,'2025_07_01_000002_create_kelas_table',1);
INSERT INTO migrations VALUES(6,'2025_07_01_000003_create_murid_table',1);
INSERT INTO migrations VALUES(7,'2025_07_01_000004_create_kategori_pelanggaran_table',1);
INSERT INTO migrations VALUES(8,'2025_07_01_000005_create_jenis_pelanggaran_table',1);
INSERT INTO migrations VALUES(9,'2025_07_01_000006_create_pelanggaran_table',1);
INSERT INTO migrations VALUES(10,'2025_07_01_000007_create_sanksi_table',1);
INSERT INTO migrations VALUES(11,'2025_07_01_000008_create_surat_peringatan_table',1);
