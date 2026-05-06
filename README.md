# 🎓 Sistem Manajemen Magang Profesional

**Sistem Pendaftaran, Penerimaan, dan Monitoring Peserta Magang Berbasis Web**

Aplikasi modern dan responsif untuk mengelola program magang perusahaan dengan dashboard admin, monitoring peserta, absensi online, dan laporan terintegrasi.

---

## 📋 Daftar Isi

- [Teknologi](#teknologi)
- [Fitur Utama](#fitur-utama)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Penggunaan](#penggunaan)
- [Struktur Database](#struktur-database)
- [Dokumentasi](#dokumentasi)

---

## 🛠️ Teknologi

| Komponen | Teknologi |
|----------|-----------|
| **Backend** | Laravel 11 |
| **Frontend** | Blade Template + Tailwind CSS |
| **Database** | MySQL 8.0+ |
| **Authentication** | Laravel Breeze |
| **UI Components** | Alpine.js |
| **Charts** | ApexCharts |
| **File Upload** | Laravel Storage |
| **Email** | SMTP |
| **Server** | Apache/XAMPP |
| **Version Control** | Git |

---

## ✨ Fitur Utama

### 1. **Landing Page Profesional**
- Hero section yang menarik
- Informasi program magang
- Benefit dan keuntungan
- Alur pendaftaran
- FAQ lengkap
- Footer dengan informasi kontak
- Responsive design

### 2. **Sistem Authentication**
- Login peserta & admin
- Register dengan verifikasi email
- Forgot password
- Two-factor authentication (optional)
- Social login ready

### 3. **Dashboard Peserta**
- Profil peserta lengkap
- Upload CV, surat pengantar, transkrip
- Upload foto profil
- Tracker status pendaftaran real-time
- History interview dan hasil
- Daily activity log

### 4. **Sistem Pendaftaran**
- Form registrasi multi-step
- Upload dokumen persyaratan
- Validasi dokumen otomatis
- Status tracking
- Notifikasi email realtime

### 5. **Dashboard Admin/HRD**
- Manajemen peserta
- Seleksi dan penilaian
- Manajemen lowongan magang
- Pengaturan divisi
- Manajemen jadwal interview
- Pengumuman & newsletter

### 6. **Monitoring Peserta**
- Absensi online dengan check-in/out
- Daily activity report
- Progress monitoring
- Penilaian kinerja
- Feedback sistem

### 7. **Sistem Absensi**
- QR Code check-in
- Timestamp otomatis
- Foto kehadiran
- Rekap absensi
- Export PDF/Excel

### 8. **Notifikasi**
- Email notification
- Toast notification
- Push notification
- WhatsApp integration (optional)

### 9. **Sistem Interview**
- Jadwal interview
- Video call link
- Input hasil interview
- Feedback peserta

### 10. **Laporan & Export**
- Export PDF
- Export Excel
- Print laporan
- Statistik dashboard
- Analytics lengkap

### 11. **Role-Based Access**
- Admin
- HRD
- Pembimbing
- Peserta Magang
- Super Admin

### 12. **Keamanan**
- CSRF Protection
- Form Validation
- Password encryption
- Session management
- File upload validation
- Rate limiting

---

## 📦 Instalasi

### Prerequisites
```bash
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & NPM
- Git
```

### Step-by-Step Installation

**1. Clone Repository**
```bash
git clone https://github.com/dzakyrafaelkb/internship-management-system.git
cd internship-management-system
```

**2. Install Dependencies**
```bash
composer install
npm install
```

**3. Copy Environment File**
```bash
cp .env.example .env
```

**4. Generate Application Key**
```bash
php artisan key:generate
```

**5. Konfigurasi Database**
Buka `.env` dan sesuaikan:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=internship_db
DB_USERNAME=root
DB_PASSWORD=
```

**6. Run Migrations & Seeders**
```bash
php artisan migrate
php artisan db:seed
```

**7. Build Assets**
```bash
npm run dev
# atau untuk production
npm run build
```

**8. Create Storage Link**
```bash
php artisan storage:link
```

**9. Jalankan Server**
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

---

## ⚙️ Konfigurasi

### Email Configuration (SMTP)
Buka `.env` dan konfigurasi SMTP:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@internship.com
MAIL_FROM_NAME="Sistem Magang"
```

### File Storage Configuration
```env
FILESYSTEM_DISK=public
```

### Queue Configuration (Optional)
```env
QUEUE_CONNECTION=database
```

---

## 🚀 Penggunaan

### Default Credentials

#### Admin Account
```
Email: admin@internship.com
Password: password
```

#### HRD Account
```
Email: hrd@internship.com
Password: password
```

#### Peserta Sample
```
Email: peserta@internship.com
Password: password
```

### Fitur Login
1. Buka halaman login
2. Masukkan email dan password
3. Pilih role (Peserta/Admin/HRD)
4. Tekan Login

### Fitur Peserta
1. **Edit Profil**: Dashboard → Profile
2. **Upload Dokumen**: Dashboard → Documents
3. **Lihat Status**: Dashboard → Application Status
4. **Absensi**: Dashboard → Attendance
5. **Activity Report**: Dashboard → Daily Report

### Fitur Admin
1. **Dashboard**: Analytics & Statistics
2. **Kelola Peserta**: Admin → Participants
3. **Seleksi**: Admin → Selection
4. **Interview**: Admin → Interview Schedule
5. **Laporan**: Admin → Reports
6. **Export**: Reports → Download

---

## 📊 Struktur Database

### Tabel Utama

```sql
-- Users (Authentication)
- id, name, email, password, role, created_at

-- Peserta (Data Peserta)
- id, user_id, nim, kampus, jurusan, email, hp, alamat, tgl_lahir

-- Pendaftaran (Aplikasi)
- id, peserta_id, status, posisi, periode, created_at

-- Lowongan (Job Opening)
- id, divisi_id, posisi, deskripsi, kuota, periode

-- Divisi (Department)
- id, nama, deskripsi

-- Absensi (Attendance)
- id, peserta_id, check_in, check_out, foto, keterangan

-- Laporan Harian (Daily Report)
- id, peserta_id, tanggal, aktivitas, progress

-- Interview (Interview)
- id, peserta_id, jadwal, link, hasil, nilai

-- Penilaian (Evaluation)
- id, peserta_id, pembimbing_id, nilai, komentar

-- Notifikasi (Notification)
- id, user_id, judul, pesan, dibaca
```

---

## 📁 Struktur Folder

```
internship-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── Admin/
│   │   │   ├── Peserta/
│   │   │   └── API/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Peserta.php
│   │   ├── Pendaftaran.php
│   │   ├── Lowongan.php
│   │   ├── Divisi.php
│   │   ├── Absensi.php
│   │   ├── LaporanHarian.php
│   │   ├── Interview.php
│   │   ├── Penilaian.php
│   │   └── Notifikasi.php
│   ├── Mail/
│   │   ├── PendaftaranDiterima.php
│   │   ├── JadwalInterview.php
│   │   └── PendaftaranDitolak.php
│   └── Services/
│       ├── AbsensiService.php
│       ├── NotifikasiService.php
│       └── ReportService.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── auth/
│       ├── dashboard/
│       ├── admin/
│       └── peserta/
├── routes/
│   ├── web.php
│   ├── api.php
│   └── auth.php
├── public/
│   ├── css/
│   ├── js/
│   └── images/
├── tests/
├── storage/
├── .env.example
├── .gitignore
├── composer.json
├── package.json
└── README.md
```

---

## 📚 Dokumentasi Lengkap

### Entity Relationship Diagram (ERD)
[Lihat ERD](./docs/ERD.md)

### Use Case Diagram
[Lihat Use Case](./docs/USE_CASE.md)

### API Documentation
[Lihat API Docs](./docs/API.md)

### Installation Guide
[Lihat Panduan Instalasi](./docs/INSTALLATION.md)

### User Manual
[Lihat Panduan Pengguna](./docs/USER_MANUAL.md)

---

## 🔐 Keamanan

✅ CSRF Protection
✅ SQL Injection Prevention
✅ XSS Prevention
✅ Password Hashing (Bcrypt)
✅ Rate Limiting
✅ File Upload Validation
✅ Session Management
✅ HTTPS Ready

---

## 📧 Email & Notifikasi

Sistem terintegrasi dengan:
- ✉️ Email SMTP
- 🔔 Toast Notification
- 📱 Push Notification
- 💬 WhatsApp (Optional)

---

## 🤝 Kontribusi

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📄 Lisensi

Distributed under MIT License. See LICENSE for more information.

---

## 📞 Support

Untuk bantuan atau pertanyaan:
- 📧 Email: support@internship.com
- 💬 WhatsApp: +62-xxx-xxxx-xxxx
- 🐛 GitHub Issues: [Issues](https://github.com/dzakyrafaelkb/internship-management-system/issues)

---

## 👨‍💻 Author

**Dzaky Rafael KB**

---

**Made with ❤️ for Internship Management**
