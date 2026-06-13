# PortalLulus

Sistem Informasi Kelulusan Siswa berbasis web untuk SMP. Dibangun menggunakan PHP Native dengan arsitektur MVC sederhana.

## Fitur Utama
- **Panel Admin**: Kelola data siswa, mata pelajaran, nilai, kelas, dan pengaturan SKL
- **Import Excel**: Import data siswa dan nilai dari file Excel/CSV secara cerdas (auto-detect kolom)
- **Cetak SKL**: Generate Surat Keterangan Lulus dalam format siap cetak/PDF
- **Portal Siswa**: Siswa login dengan NISN untuk melihat status kelulusan dan cetak SKL
- **Countdown Pengumuman**: Fitur hitung mundur menuju waktu pengumuman kelulusan

## Persyaratan Sistem
- PHP >= 8.1
- MySQL / MariaDB
- Composer
- Apache (mod_rewrite aktif)

## Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/USERNAME/portallulus.git
cd portallulus
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
```
Edit file `.env` sesuai konfigurasi database hosting Anda:
```
DB_HOST=127.0.0.1
DB_NAME=portallulus
DB_USER=root
DB_PASS=password_anda
DB_CHARSET=utf8mb4
BASE_URL=
```

### 4. Setup Database
Import file `database.sql` ke MySQL:
```bash
mysql -u root -p portallulus < database.sql
```

### 5. Atur Permission (Linux/Hosting)
```bash
chmod -R 755 public/uploads
```

## Login Default
- **Admin**: username `admin`, password `password`
- **Siswa**: login menggunakan NISN masing-masing

## Struktur Folder
```
portallulus/
├── app/
│   ├── controllers/    # Controller (MVC)
│   ├── core/           # Database, Router
│   ├── helpers/        # Helper functions
│   └── views/          # Views & layouts
├── config/             # Konfigurasi app & database
├── database/           # Migration SQL tambahan
├── public/             # Document root (index.php, css, uploads)
├── vendor/             # Composer dependencies (auto-generated)
├── .env.example        # Template environment
├── composer.json       # PHP dependencies
└── database.sql        # Schema database lengkap
```

## Deployment ke Hosting
1. Upload seluruh file (kecuali `.env`) ke hosting
2. Arahkan **Document Root** ke folder `public/`
3. Buat file `.env` di server dengan konfigurasi database hosting
4. Import `database.sql` via phpMyAdmin
5. Pastikan folder `public/uploads/` writable (chmod 755)

## Lisensi
MIT License
