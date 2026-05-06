# 📊 Struktur Database - Sistem Manajemen Magang

## Daftar Tabel

1. [users](#users)
2. [peserta](#peserta)
3. [divisi](#divisi)
4. [lowongan](#lowongan)
5. [pendaftaran](#pendaftaran)
6. [interview](#interview)
7. [penilaian](#penilaian)
8. [absensi](#absensi)
9. [laporan_harian](#laporan_harian)
10. [laporan_mingguan](#laporan_mingguan)
11. [notifikasi](#notifikasi)
12. [documents](#documents)

---

## Tabel Detail

### users
Tabel autentikasi dan manajemen pengguna

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'hrd', 'pembimbing', 'peserta') DEFAULT 'peserta',
    is_active BOOLEAN DEFAULT true,
    last_login_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    INDEX idx_email (email),
    INDEX idx_role (role)
);
```

**Kolom:**
- `id`: Primary key
- `name`: Nama lengkap pengguna
- `email`: Email unik pengguna
- `email_verified_at`: Timestamp verifikasi email
- `password`: Password terenkripsi (bcrypt)
- `role`: Tipe pengguna (admin/hrd/pembimbing/peserta)
- `is_active`: Status aktivasi akun
- `last_login_at`: Waktu login terakhir
- `remember_token`: Token "remember me"

---

### peserta
Data lengkap peserta magang

```sql
CREATE TABLE peserta (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    nim VARCHAR(50),
    kampus VARCHAR(255),
    jurusan VARCHAR(255),
    tanggal_lahir DATE,
    jenis_kelamin ENUM('laki-laki', 'perempuan'),
    no_hp VARCHAR(15),
    alamat TEXT,
    kota VARCHAR(100),
    provinsi VARCHAR(100),
    foto_profil VARCHAR(255) NULL,
    status_peserta ENUM('aktif', 'non-aktif', 'selesai', 'berhenti') DEFAULT 'aktif',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_nim (nim),
    INDEX idx_kampus (kampus)
);
```

**Kolom:**
- `id`: Primary key
- `user_id`: Foreign key ke users
- `nim`: Nomor Induk Mahasiswa/Siswa
- `kampus`: Asal kampus/sekolah
- `jurusan`: Jurusan/Program studi
- `tanggal_lahir`: Tanggal lahir peserta
- `jenis_kelamin`: Gender
- `no_hp`: Nomor telepon
- `alamat`: Alamat lengkap
- `kota`: Kota domisili
- `provinsi`: Provinsi domisili
- `foto_profil`: Path foto profil
- `status_peserta`: Status keaktifan peserta

---

### divisi
Departemen/Divisi perusahaan

```sql
CREATE TABLE divisi (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL UNIQUE,
    deskripsi TEXT,
    kepala_divisi VARCHAR(255),
    kontak_hp VARCHAR(15),
    is_aktif BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    INDEX idx_nama (nama)
);
```

**Kolom:**
- `id`: Primary key
- `nama`: Nama divisi
- `deskripsi`: Deskripsi divisi
- `kepala_divisi`: Nama kepala divisi
- `kontak_hp`: Nomor HP kepala divisi
- `is_aktif`: Status aktif divisi

---

### lowongan
Lowongan/Kesempatan magang

```sql
CREATE TABLE lowongan (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    divisi_id BIGINT UNSIGNED NOT NULL,
    posisi VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    persyaratan TEXT,
    kuota INT DEFAULT 1,
    periode_mulai DATE,
    periode_selesai DATE,
    status_lowongan ENUM('buka', 'tutup', 'selesai') DEFAULT 'buka',
    is_aktif BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (divisi_id) REFERENCES divisi(id) ON DELETE CASCADE,
    INDEX idx_divisi (divisi_id),
    INDEX idx_status (status_lowongan)
);
```

**Kolom:**
- `id`: Primary key
- `divisi_id`: Foreign key ke divisi
- `posisi`: Nama posisi magang
- `deskripsi`: Deskripsi pekerjaan
- `persyaratan`: Persyaratan/Kualifikasi
- `kuota`: Jumlah peserta yang dibutuhkan
- `periode_mulai`: Tanggal mulai periode
- `periode_selesai`: Tanggal selesai periode
- `status_lowongan`: Status lowongan (buka/tutup/selesai)

---

### pendaftaran
Aplikasi/Pendaftaran peserta magang

```sql
CREATE TABLE pendaftaran (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    peserta_id BIGINT UNSIGNED NOT NULL,
    lowongan_id BIGINT UNSIGNED NOT NULL,
    status_pendaftaran ENUM('menunggu_review', 'seleksi_berkas', 'interview', 'diterima', 'ditolak', 'selesai_magang') DEFAULT 'menunggu_review',
    tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    catatan_penolakan TEXT NULL,
    reviewed_by BIGINT UNSIGNED NULL,
    reviewed_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (peserta_id) REFERENCES peserta(id) ON DELETE CASCADE,
    FOREIGN KEY (lowongan_id) REFERENCES lowongan(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_peserta (peserta_id),
    INDEX idx_lowongan (lowongan_id),
    INDEX idx_status (status_pendaftaran),
    UNIQUE KEY unique_daftar (peserta_id, lowongan_id)
);
```

**Kolom:**
- `id`: Primary key
- `peserta_id`: Foreign key ke peserta
- `lowongan_id`: Foreign key ke lowongan
- `status_pendaftaran`: Status aplikasi
- `tanggal_daftar`: Waktu mendaftar
- `catatan_penolakan`: Alasan penolakan (jika ditolak)
- `reviewed_by`: Admin yang melakukan review
- `reviewed_at`: Waktu review

---

### interview
Jadwal dan hasil interview

```sql
CREATE TABLE interview (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    pendaftaran_id BIGINT UNSIGNED NOT NULL,
    jadwal_interview DATETIME,
    link_meeting VARCHAR(500) NULL,
    pewawancara_id BIGINT UNSIGNED NOT NULL,
    hasil_interview TEXT NULL,
    nilai_interview INT NULL,
    status_interview ENUM('terjadwal', 'selesai', 'dibatalkan') DEFAULT 'terjadwal',
    catatan_interview TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (pendaftaran_id) REFERENCES pendaftaran(id) ON DELETE CASCADE,
    FOREIGN KEY (pewawancara_id) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_pendaftaran (pendaftaran_id),
    INDEX idx_jadwal (jadwal_interview),
    INDEX idx_status (status_interview)
);
```

**Kolom:**
- `id`: Primary key
- `pendaftaran_id`: Foreign key ke pendaftaran
- `jadwal_interview`: Waktu interview
- `link_meeting`: Link video conference
- `pewawancara_id`: Admin/HRD yang melakukan interview
- `hasil_interview`: Catatan hasil interview
- `nilai_interview`: Nilai interview (0-100)
- `status_interview`: Status interview (terjadwal/selesai/dibatalkan)

---

### penilaian
Penilaian kinerja peserta magang

```sql
CREATE TABLE penilaian (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    peserta_id BIGINT UNSIGNED NOT NULL,
    pembimbing_id BIGINT UNSIGNED NOT NULL,
    nilai_akademik INT,
    nilai_sikap INT,
    nilai_keterampilan INT,
    nilai_disiplin INT,
    total_nilai INT GENERATED ALWAYS AS (
        ROUND((nilai_akademik + nilai_sikap + nilai_keterampilan + nilai_disiplin) / 4, 2)
    ) STORED,
    komentar TEXT,
    tanggal_penilaian DATE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (peserta_id) REFERENCES peserta(id) ON DELETE CASCADE,
    FOREIGN KEY (pembimbing_id) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_peserta (peserta_id),
    INDEX idx_pembimbing (pembimbing_id),
    INDEX idx_tanggal (tanggal_penilaian)
);
```

**Kolom:**
- `id`: Primary key
- `peserta_id`: Foreign key ke peserta
- `pembimbing_id`: Foreign key ke pembimbing
- `nilai_akademik`: Nilai akademik (0-100)
- `nilai_sikap`: Nilai sikap/attitude (0-100)
- `nilai_keterampilan`: Nilai keterampilan (0-100)
- `nilai_disiplin`: Nilai disiplin (0-100)
- `total_nilai`: Rata-rata nilai (generated)
- `komentar`: Catatan penilaian

---

### absensi
Sistem absensi online peserta

```sql
CREATE TABLE absensi (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    peserta_id BIGINT UNSIGNED NOT NULL,
    tanggal DATE NOT NULL,
    check_in TIME NULL,
    check_out TIME NULL,
    foto_check_in VARCHAR(255) NULL,
    foto_check_out VARCHAR(255) NULL,
    keterangan TEXT NULL,
    status_hadir ENUM('hadir', 'izin', 'sakit', 'libur', 'tidak_hadir') DEFAULT 'tidak_hadir',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (peserta_id) REFERENCES peserta(id) ON DELETE CASCADE,
    INDEX idx_peserta (peserta_id),
    INDEX idx_tanggal (tanggal),
    UNIQUE KEY unique_absensi (peserta_id, tanggal)
);
```

**Kolom:**
- `id`: Primary key
- `peserta_id`: Foreign key ke peserta
- `tanggal`: Tanggal absensi
- `check_in`: Waktu check-in
- `check_out`: Waktu check-out
- `foto_check_in`: Path foto saat check-in
- `foto_check_out`: Path foto saat check-out
- `keterangan`: Catatan kehadiran
- `status_hadir`: Status hadir/izin/sakit/libur

---

### laporan_harian
Laporan aktivitas harian peserta

```sql
CREATE TABLE laporan_harian (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    peserta_id BIGINT UNSIGNED NOT NULL,
    tanggal DATE NOT NULL,
    pekerjaan_yang_dikerjakan TEXT,
    kendala_yang_dihadapi TEXT,
    progress_pekerjaan INT DEFAULT 0,
    foto_aktivitas VARCHAR(255) NULL,
    status_laporan ENUM('draft', 'submitted', 'reviewed', 'approved') DEFAULT 'draft',
    reviewed_by BIGINT UNSIGNED NULL,
    reviewed_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (peserta_id) REFERENCES peserta(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_peserta (peserta_id),
    INDEX idx_tanggal (tanggal),
    INDEX idx_status (status_laporan)
);
```

**Kolom:**
- `id`: Primary key
- `peserta_id`: Foreign key ke peserta
- `tanggal`: Tanggal laporan
- `pekerjaan_yang_dikerjakan`: Deskripsi pekerjaan harian
- `kendala_yang_dihadapi`: Kendala/masalah yang dihadapi
- `progress_pekerjaan`: Progress dalam persen (0-100)
- `foto_aktivitas`: Path foto kegiatan
- `status_laporan`: Status laporan (draft/submitted/reviewed/approved)
- `reviewed_by`: Pembimbing yang review
- `reviewed_at`: Waktu di-review

---

### laporan_mingguan
Laporan ringkasan mingguan peserta

```sql
CREATE TABLE laporan_mingguan (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    peserta_id BIGINT UNSIGNED NOT NULL,
    minggu_ke INT,
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    ringkasan_pekerjaan TEXT,
    pencapaian TEXT,
    hambatan TEXT,
    rencana_minggu_depan TEXT,
    file_laporan VARCHAR(255) NULL,
    status_laporan ENUM('draft', 'submitted', 'reviewed', 'approved') DEFAULT 'draft',
    reviewed_by BIGINT UNSIGNED NULL,
    reviewed_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (peserta_id) REFERENCES peserta(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_peserta (peserta_id),
    INDEX idx_minggu (minggu_ke)
);
```

**Kolom:**
- `id`: Primary key
- `peserta_id`: Foreign key ke peserta
- `minggu_ke`: Nomor minggu
- `tanggal_mulai`: Tanggal mulai minggu
- `tanggal_selesai`: Tanggal selesai minggu
- `ringkasan_pekerjaan`: Ringkasan pekerjaan selama seminggu
- `pencapaian`: Target yang dicapai
- `hambatan`: Hambatan yang dihadapi
- `rencana_minggu_depan`: Rencana untuk minggu depan
- `file_laporan`: Path file laporan (PDF/DOC)
- `status_laporan`: Status laporan

---

### notifikasi
Sistem notifikasi untuk pengguna

```sql
CREATE TABLE notifikasi (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    judul VARCHAR(255) NOT NULL,
    pesan TEXT,
    tipe ENUM('info', 'success', 'warning', 'error', 'interview', 'status') DEFAULT 'info',
    terkait_peserta_id BIGINT UNSIGNED NULL,
    sudah_dibaca BOOLEAN DEFAULT false,
    dibaca_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (terkait_peserta_id) REFERENCES peserta(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_sudah_dibaca (sudah_dibaca),
    INDEX idx_created (created_at)
);
```

**Kolom:**
- `id`: Primary key
- `user_id`: Foreign key ke users
- `judul`: Judul notifikasi
- `pesan`: Isi pesan
- `tipe`: Tipe notifikasi
- `terkait_peserta_id`: Peserta yang terkait (opsional)
- `sudah_dibaca`: Status dibaca
- `dibaca_at`: Waktu dibaca

---

### documents
Dokumen persyaratan peserta

```sql
CREATE TABLE documents (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    peserta_id BIGINT UNSIGNED NOT NULL,
    tipe_dokumen ENUM('cv', 'surat_pengantar', 'transkrip', 'ijazah', 'ktp', 'lainnya') NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_name VARCHAR(255),
    file_size INT,
    file_type VARCHAR(50),
    status_dokumen ENUM('uploaded', 'verified', 'rejected') DEFAULT 'uploaded',
    catatan_verifikasi TEXT NULL,
    verified_by BIGINT UNSIGNED NULL,
    verified_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (peserta_id) REFERENCES peserta(id) ON DELETE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_peserta (peserta_id),
    INDEX idx_tipe (tipe_dokumen)
);
```

**Kolom:**
- `id`: Primary key
- `peserta_id`: Foreign key ke peserta
- `tipe_dokumen`: Jenis dokumen
- `file_path`: Path penyimpanan file
- `file_name`: Nama file asli
- `file_size`: Ukuran file
- `file_type`: Tipe MIME file
- `status_dokumen`: Status verifikasi
- `catatan_verifikasi`: Catatan dari verifikasi
- `verified_by`: Admin yang memverifikasi
- `verified_at`: Waktu verifikasi

---

## Entity Relationship Diagram (ERD)

```
users (1) ──── (1) peserta
  │
  ├── (1) ──── (∞) absensi
  ├── (1) ──── (∞) interview (pewawancara_id)
  ├── (1) ──── (∞) penilaian (pembimbing_id)
  ├── (1) ──── (∞) notifikasi
  └── (1) ──── (∞) laporan_harian (reviewed_by)

peserta (1) ──── (∞) pendaftaran
peserta (1) ──── (∞) absensi
peserta (1) ──── (∞) documents
peserta (1) ──── (∞) penilaian
peserta (1) ──── (∞) laporan_harian
peserta (1) ──── (∞) laporan_mingguan

lowongan (1) ──── (∞) pendaftaran
divisi (1) ──── (∞) lowongan

pendaftaran (1) ──── (∞) interview
```

---

## Relasi Antar Tabel

| Tabel A | Tabel B | Tipe | Foreign Key |
|---------|---------|------|-------------|
| users | peserta | 1:1 | peserta.user_id |
| users | interview | 1:∞ | interview.pewawancara_id |
| users | penilaian | 1:∞ | penilaian.pembimbing_id |
| users | notifikasi | 1:∞ | notifikasi.user_id |
| peserta | pendaftaran | 1:∞ | pendaftaran.peserta_id |
| peserta | absensi | 1:∞ | absensi.peserta_id |
| peserta | documents | 1:∞ | documents.peserta_id |
| peserta | penilaian | 1:∞ | penilaian.peserta_id |
| peserta | laporan_harian | 1:∞ | laporan_harian.peserta_id |
| peserta | laporan_mingguan | 1:∞ | laporan_mingguan.peserta_id |
| divisi | lowongan | 1:∞ | lowongan.divisi_id |
| lowongan | pendaftaran | 1:∞ | pendaftaran.lowongan_id |
| pendaftaran | interview | 1:∞ | interview.pendaftaran_id |

---

## Indeks yang Dibuat

Setiap tabel memiliki indeks untuk performa query yang optimal:

- **Primary Key**: Semua ID field
- **Foreign Key**: Semua kolom foreign key
- **Search Fields**: email, nim, nama
- **Filter Fields**: role, status, tanggal
- **Unique Constraint**: email, nim, unique_daftar

---

## Dokumentasi Selesai ✅

Database ini dirancang untuk mendukung semua fitur sistem manajemen magang dengan:
- ✅ Integritas data yang kuat
- ✅ Performa query yang optimal
- ✅ Skalabilitas untuk pertumbuhan data
- ✅ Keamanan data yang terjaga
