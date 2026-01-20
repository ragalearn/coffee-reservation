# ☕ Coffee Reservation System

Aplikasi **Coffee Reservation System** adalah sistem reservasi coffee shop berbasis web yang dibangun menggunakan **Laravel**.  
Aplikasi ini memungkinkan pelanggan melakukan reservasi meja dan admin mengelola data reservasi, kategori, pengguna, serta laporan.

---

## ✨ Fitur Utama

### 👤 Pelanggan
- Registrasi & Login (termasuk OTP / Social Login)
- Melihat kategori coffee
- Membuat reservasi coffee
- Review sebelum konfirmasi reservasi
- Melihat & membatalkan reservasi
- Mengelola profil pengguna

### 🛠 Admin
- Dashboard admin
- Manajemen kategori coffee
- Manajemen reservasi pelanggan
- Manajemen pengguna
- Laporan reservasi
- Pengaturan aplikasi

---

## 🧰 Tech Stack

- **Backend**: Laravel
- **Frontend**: Blade + Tailwind CSS
- **Build Tool**: Vite
- **Database**: MySQL
- **Authentication**: Laravel Auth + OTP
- **JavaScript**: Alpine.js, Axios

---

## 📦 Instalasi

Ikuti langkah berikut untuk menjalankan project secara lokal:

### 1️⃣ Clone Repository
```bash
git clone https://github.com/username/coffee-reservation.git
cd coffee-reservation
Install Dependency Backend
composer install

3️⃣ Install Dependency Frontend
npm install

4️⃣ Konfigurasi Environment
cp .env.example .env
php artisan key:generate


Sesuaikan konfigurasi database di file .env:

DB_DATABASE=coffee_reservation
DB_USERNAME=root
DB_PASSWORD=

5️⃣ Migrasi Database
php artisan migrate --seed

6️⃣ Jalankan Aplikasi
# Jalankan Laravel
php artisan serve

# Jalankan Vite
npm run dev


Aplikasi dapat diakses di:

http://localhost:8000
