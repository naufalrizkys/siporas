CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "role" varchar not null default 'user',
  "google_id" varchar,
  "avatar" varchar
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
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
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE INDEX "cache_expiration_index" on "cache"("expiration");
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE INDEX "cache_locks_expiration_index" on "cache_locks"("expiration");
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
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
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" varchar not null,
  "queue" varchar not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE INDEX "failed_jobs_connection_queue_failed_at_index" on "failed_jobs"(
  "connection",
  "queue",
  "failed_at"
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "pengurus"(
  "id" integer primary key autoincrement not null,
  "ormas_id" integer not null,
  "nama" varchar not null,
  "jabatan" varchar not null,
  "nik" varchar,
  "telepon" varchar,
  "email" varchar,
  "foto" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("ormas_id") references "ormas"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "kegiatan"(
  "id" integer primary key autoincrement not null,
  "ormas_id" integer not null,
  "judul" varchar not null,
  "deskripsi" text not null,
  "tanggal_mulai" date not null,
  "tanggal_selesai" date,
  "lokasi" varchar not null,
  "foto" varchar,
  "status" varchar check("status" in('akan_datang', 'berlangsung', 'selesai')) not null default 'akan_datang',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("ormas_id") references "ormas"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "pengajuan"(
  "id" integer primary key autoincrement not null,
  "nama_pemohon" varchar not null,
  "nik" varchar not null,
  "telepon" varchar not null,
  "email" varchar not null,
  "jenis_layanan" varchar check("jenis_layanan" in('pendaftaran_ormas', 'perpanjangan_skt', 'perubahan_data', 'pencabutan_skt', 'surat_keterangan')) not null,
  "ormas_id" integer,
  "keterangan" text,
  "dokumen" varchar,
  "status" varchar check("status" in('menunggu', 'diproses', 'disetujui', 'ditolak')) not null default 'menunggu',
  "catatan_admin" text,
  "created_at" datetime,
  "updated_at" datetime,
  "data_perubahan" text,
  "data_sebelum" text,
  foreign key("ormas_id") references "ormas"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "sliders"(
  "id" integer primary key autoincrement not null,
  "judul" varchar,
  "deskripsi" text,
  "gambar" varchar not null,
  "link" varchar,
  "urutan" integer not null default '0',
  "aktif" tinyint(1) not null default '1',
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "settings"(
  "id" integer primary key autoincrement not null,
  "key" varchar not null,
  "value" text,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "settings_key_unique" on "settings"("key");
CREATE TABLE IF NOT EXISTS "ormas"(
  "id" integer primary key autoincrement not null,
  "nama_ormas" varchar not null,
  "singkatan" varchar,
  "nomor_skt" varchar,
  "tanggal_berdiri" date,
  "bidang_kegiatan" varchar not null,
  "visi" text,
  "misi" text,
  "alamat_sekretariat" text not null,
  "kelurahan" varchar,
  "kecamatan" varchar,
  "kota" varchar not null,
  "provinsi" varchar not null,
  "telepon" varchar,
  "email" varchar,
  "website" varchar,
  "logo" varchar,
  "status" varchar not null default('menunggu'),
  "created_at" datetime,
  "updated_at" datetime,
  "user_id" integer,
  "latitude" numeric,
  "longitude" numeric,
  foreign key("user_id") references "users"("id") on delete set null
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2026_09_15_085450_create_ormas_table',1);
INSERT INTO migrations VALUES(5,'2026_09_15_085451_create_pengurus_table',1);
INSERT INTO migrations VALUES(6,'2026_09_15_085452_create_kegiatan_table',1);
INSERT INTO migrations VALUES(7,'2026_09_15_085453_create_pengajuan_table',1);
INSERT INTO migrations VALUES(8,'2026_09_22_062719_create_sliders_table',2);
INSERT INTO migrations VALUES(9,'2026_09_22_082057_add_role_to_users_table',3);
INSERT INTO migrations VALUES(10,'2026_09_22_114451_add_data_perubahan_to_pengajuan_table',4);
INSERT INTO migrations VALUES(11,'2026_09_22_132129_create_settings_table',5);
INSERT INTO migrations VALUES(12,'2026_09_22_150000_add_google_id_to_users_table',6);
INSERT INTO migrations VALUES(13,'2026_09_25_120000_add_ormas_fields_and_coordinates',7);
INSERT INTO migrations VALUES(14,'2026_09_25_142456_add_data_sebelum_to_pengajuan_table',8);
