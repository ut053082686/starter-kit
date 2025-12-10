# 🚀 Laravel 12 + Filament v4 Starter Kit

**Starter Kit Admin Panel** modern, aman, dan siap pakai. Dibangun di atas fondasi **Laravel 12** dan **Filament v4** (Bleeding Edge) dengan integrasi **Tailwind CSS v4**.

Cocok untuk memulai proyek aplikasi back-office, SAAS, atau sistem manajemen internal dengan fitur keamanan dan UI/UX yang sudah matang.

-----

## ✨ Fitur Unggulan

### 🛡️ Keamanan & RBAC (Role-Based Access Control)

  - Terintegrasi dengan **`spatie/laravel-permission`**.
  - **3 Role Default:** Super Admin, Sub Admin, dan User.
  - **Policy & Gate:** Menu sensitif (seperti Permission & Audit Log) otomatis disembunyikan dari user biasa.
  - **Super Admin Gate:** Super Admin otomatis memiliki akses penuh tanpa perlu assign permission manual.

### 👁️ Audit Logging (CCTV Aplikasi)

  - Terintegrasi dengan **`spatie/laravel-activitylog`**.
  - Mencatat **Siapa**, **Kapan**, dan **Apa** yang diubah pada data penting (User, Role, dll).
  - Menu "Activities" bersifat **Read-Only** dan hanya bisa diakses oleh Super Admin.

### 🎨 UI/UX Personal & Modern

  - **Custom Theme:** Menggunakan font **Poppins** (Google Fonts) dan warna tema **Indigo**.
  - **Logo Kustom:** Support logo SVG untuk mode Terang & Gelap.
  - **Custom Login:** Halaman login yang sudah disesuaikan (bukan default Filament).
  - **Dashboard Dinamis:**
      - **Admin:** Melihat Widget Statistik (Total User, Roles, dll).
      - **User:** Melihat Widget Sapaan (Welcome Banner) dengan Avatar.

### ⚡ Fitur Produktivitas

  - **Global Search:** Cari User instan dengan tekan **`Ctrl + K`**.
  - **Sidebar Grouping:** Menu dikelompokkan rapi dalam folder "Settings".
  - **Custom Profile:** Edit nama, email, password, dan **Upload Avatar** (dengan perbaikan bug *silent crash*).

-----

## 🛠️ Persyaratan Sistem

  - PHP 8.2 atau lebih baru
  - Composer
  - Node.js & NPM
  - Database (MySQL / MariaDB / PostgreSQL)

-----

## 📦 Panduan Instalasi Cepat

1.  **Clone Repositori**

    ```bash
    git clone https://github.com/username-anda/starter-kit.git
    cd starter-kit
    ```

2.  **Install Dependensi**

    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    Salin file `.env.example` dan atur koneksi database Anda.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    *Pastikan mengatur `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di file `.env`.*

4.  **Setup Database & Seeding (PENTING)**
    Perintah ini akan membuat tabel dan mengisi data Role, Permission, dan User default.

    ```bash
    php artisan migrate:fresh --seed
    ```

5.  **Link Storage (Untuk Avatar)**

    ```bash
    php artisan storage:link
    ```

6.  **Build Assets (Tailwind & Font)**

    ```bash
    npm run build
    ```

7.  **Jalankan Server**

    ```bash
    php artisan serve
    ```

    Akses aplikasi di: `http://127.0.0.1:8000/admin`

-----

## 🔐 Akun Default (Login Credentials)

Gunakan akun berikut untuk menguji pembagian hak akses (RBAC):

| Role | Email | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@admin.com` | `admin123` | **Full Akses**. Bisa melihat Audit Log, Permissions, dan Widget Statistik. |
| **Sub Admin** | `test@example.com` | `password123` | Bisa mengelola User & Role. **Tidak bisa** melihat Audit Log. |
| **User** | `admin@gmail.com` | `password123` | **Akses Terbatas**. Hanya Dashboard Personal & Edit Profil. |

-----

## 🧩 Struktur Kustomisasi

Jika Anda ingin mengubah identitas aplikasi:

  - **Nama & Warna:** Edit file `app/Providers/Filament/AdminPanelProvider.php`.
  - **Logo:** Ganti file SVG di folder `public/images/`.
      - `logo-light.svg` (Untuk mode terang)
      - `logo-dark.svg` (Untuk mode gelap)
      - `favicon.svg`
  - **User Widget:** Edit file `resources/views/filament/widgets/user-welcome-widget.blade.php`.
  - **Zona Waktu:** Diatur ke `Asia/Jakarta` pada file `.env`.

-----

## 📝 Lisensi

Starter Kit ini open-sourced software di bawah lisensi [MIT license](https://opensource.org/licenses/MIT).
