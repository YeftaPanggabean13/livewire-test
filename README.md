# User & Order Tracker

Aplikasi web berbasis **Laravel 12** + **Livewire 4** untuk manajemen data pengguna dan pelaporan order per kota secara real-time.

---

## Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Fitur](#fitur)
- [Tech Stack](#tech-stack)
- [Skema Database](#skema-database)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Struktur Proyek](#struktur-proyek)
- [Rute Aplikasi](#rute-aplikasi)
- [Komponen](#komponen)

---

## Tentang Proyek

**User & Order Tracker** adalah aplikasi internal untuk:

1. **Manajemen Pengguna** — Melihat, mencari, dan mengedit data pengguna secara langsung tanpa page reload (reactive via Livewire).
2. **Laporan Order per Kota** — Menampilkan rekapitulasi total order dan total nominal dari setiap kota, dengan filter otomatis hanya kota yang memiliki akumulasi order di atas **Rp 10.000.000**.

---

## Fitur

### Halaman Manajemen Pengguna (`/users`)
- Tabel daftar pengguna dengan kolom: Nama, Email, Jabatan
- **Live search** berdasarkan nama (debounce 300ms, tanpa refresh halaman)
- **Pagination** otomatis (10 data per halaman)
- **Edit inline via modal** — klik tombol Edit, ubah nama/email, simpan langsung
- Validasi server-side: nama wajib & min. 3 karakter, email wajib & unik
- Flash notification setelah berhasil menyimpan

### Halaman Laporan Kota (`/city-report`)
- Laporan agregat order dari tabel `customers` JOIN `orders`
- Menampilkan: Nama Kota, Jumlah Order, Total Nominal
- Filter otomatis: hanya kota dengan `SUM(total) > 10.000.000`
- Data diproses via Eloquent + Query Builder (bukan raw SQL)

---

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend Framework | Laravel 12 (PHP ^8.2) |
| Reactive UI | Livewire 4  |
| Frontend Build | Vite + TailwindCSS |
| Database | MySQL (XAMPP) |
| Template Engine | Blade |
| Package Manager | Composer + NPM |

---

## Skema Database

### Tabel `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT (PK) | Auto increment |
| `name` | VARCHAR(100) | Nama pengguna |
| `email` | VARCHAR(100) | Unik |
| `position` | VARCHAR(50) | Jabatan |
| `created_at` | TIMESTAMP | — |
| `updated_at` | TIMESTAMP | — |

### Tabel `customers`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT (PK) | Auto increment |
| `name` | VARCHAR | Nama pelanggan |
| `city` | VARCHAR | Kota asal |
| `created_at` | TIMESTAMP | — |
| `updated_at` | TIMESTAMP | — |

### Tabel `orders`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT (PK) | Auto increment |
| `customer_id` | BIGINT (FK) | Relasi ke `customers.id` |
| `total` | DECIMAL(15,2) | Nilai order |
| `created_at` | TIMESTAMP | — |
| `updated_at` | TIMESTAMP | — |

---

## Instalasi

### Prasyarat

Pastikan sudah terinstall:
- **PHP** >= 8.2
- **Composer**
- **Node.js** >= 18 & **NPM**
- **MySQL** (via XAMPP, Laragon, atau lainnya)
- **Git**

### Langkah Instalasi

**1. Clone repository**
```bash
git clone https://github.com/YeftaPanggabean13/livewire-test.git
cd livewire-test
```

**2. Install dependensi PHP**
```bash
composer install
```

**3. Install dependensi Node.js**
```bash
npm install
```

**4. Salin file environment**
```bash
cp .env.example .env
```

**5. Generate application key**
```bash
php artisan key:generate
```

---

## Konfigurasi

Edit file `.env` sesuai konfigurasi lokal Anda:

```env
APP_NAME="User & Order Tracker"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=livewire-test
DB_USERNAME=root
DB_PASSWORD=
```

Buat database di MySQL terlebih dahulu:
```sql
CREATE DATABASE `livewire-test`;
```

Lalu jalankan migrasi:
```bash
php artisan migrate
```

---

## Menjalankan Aplikasi

### Mode Development (direkomendasikan)

Jalankan semua proses sekaligus menggunakan script `dev`:

```bash
composer run dev
```

Script ini menjalankan secara bersamaan:
- `php artisan serve` — server PHP
- `npm run dev` — Vite dev server (hot reload)
- `php artisan queue:listen` — queue worker
- `php artisan pail` — log viewer

Akses aplikasi di: **http://localhost:8000**

### Atau jalankan secara terpisah

```bash
# Terminal 1 — Laravel server
php artisan serve

# Terminal 2 — Vite (asset bundler)
npm run dev
```

### Build untuk Production

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Struktur Proyek

```
livewire-test/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── CityOrderReportController.php   # Controller laporan kota
│   ├── Livewire/
│   │   └── UserTable.php                        # Livewire component user management
│   └── Models/
│       ├── Customer.php
│       ├── Order.php
│       └── User.php
├── database/
│   └── migrations/
│       ├── ..._create_users_table.php
│       ├── ..._create_customers_table.php
│       └── ..._create_orders_table.php
├── resources/
│   └── views/
│       ├── components/
│       │   └── layouts/
│       │       └── app.blade.php               # Layout utama (digunakan Livewire)
│       ├── layouts/
│       │   └── app.blade.php                   # Layout untuk view biasa
│       ├── livewire/
│       │   └── user-table.blade.php            # View Livewire component
│       └── city-report.blade.php               # View laporan kota
└── routes/
    └── web.php                                  # Definisi rute
```

---

## Rute Aplikasi

| Method | URI | Handler | Keterangan |
|---|---|---|---|
| GET | `/` | Closure | Halaman welcome |
| GET | `/users` | `UserTable` (Livewire) | Manajemen pengguna |
| GET | `/city-report` | `CityOrderReportController@index` | Laporan order per kota |

---

## Komponen

### `App\Livewire\UserTable`

Komponen Livewire yang mengelola tabel pengguna interaktif.

| Property | Tipe | Fungsi |
|---|---|---|
| `$search` | string | Kata kunci pencarian |
| `$editingUserId` | int\|null | ID user yang sedang diedit |
| `$editingName` | string | Nama sementara saat edit |
| `$editingEmail` | string | Email sementara saat edit |

| Method | Fungsi |
|---|---|
| `updatingSearch()` | Reset halaman ke 1 saat search berubah |
| `edit($id)` | Buka modal dan isi data user |
| `cancelEdit()` | Tutup modal dan reset state |
| `save()` | Validasi & simpan perubahan ke database |
| `render()` | Query user berdasarkan pencarian + paginate |

### `App\Http\Controllers\CityOrderReportController`

Controller standar yang melakukan query JOIN antara `customers` dan `orders`, dikelompokkan per kota, lalu difilter dengan `HAVING SUM(total) > 10.000.000`.

---

## Lisensi

Proyek ini dibuat untuk keperluan pembelajaran dan pengembangan. Bebas digunakan dan dimodifikasi.
