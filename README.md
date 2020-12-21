# Warung Semur - UMKM Digital

Project ini adalah sistem informasi UMKM untuk tugas besar pemrograman web dan basis data 2.
  - [Laravel](https://laravel.com)
  - [Bootstrap 4](https://github.com/twbs/bootstrap)
  - [Argon Dashboard](https://demos.creative-tim.com/argon-dashboard/index.html)

## Persyaratan
  - Apache (Web Server)
  - Minimal PHP 7.2
  - Database Engine (Example: MySQL)
  - Composer

## Instalasi
----
**1. Kloning repository ini ke dalam komputer kamu (private repo)**
```
$ git clone https://github.com/myxzlpltk/umkm-digital.git
```
Tunggu hingga proses kloning selesai. Kemudian masuk ke dalam direktori `$ cd umkm-digital`.

**2. Install depedencies** _(The second heaviest objects in universe)_
```
$ composer install
```
Proses mungkin akan memakan waktu yang lama tergantung kecepatan internet kamu.

**3. Konfigurasi**

Duplikat file `.env.example` dengan nama `.env`. Kemudian buat database baru dan konfigurasi database di `.env` (dotenv)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=umkm
DB_USERNAME=root
DB_PASSWORD=
```

**4. Migrasi Basis Data**

Jalankan proses migrasi basis data dan seeder
```
php artisan migrate --seed
```

**5. Jalankan Program**
```
$ php artisan serve
```

## Kontribusi ##
  - Me, Myself, and I
  - Omega Christine Putri Martinus
  - Mawaddah Awaliyah
  - Bapak Wahyu Nur (Dosen Basis Data)
  - Bapak Ahmad Hamdan (Dosen Pemrograman Web)
  - Ibu Kartika (yang tugasnya selalu membuatku mengerjakan tanggungan tugas ini terlebih dahulu)
