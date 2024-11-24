# Portal Berita

Aplikasi website portal berita dapat dilihat pada URL http://winnicodenewsportal.rf.gd.

## Instalasi dan Cara Menjalankan Aplikasi

1. Jalankan perintah `git clone https://github.com/davidralphm/portal-berita` pada terminal.
2. Jalankan perintah `cd portal-berita` untuk masuk ke dalam direktori aplikasi portal berita.
3. Jalankan perintah `composer install`.
4. Copy file `.env.example` dan paste dalam direktori yang sama, kemudian rename file yang dipaste menjadi `.env`.
5. Jalankan perintah `php artisan key:generate`.
6. Ubah beberapa konfigurasi yang terdapat pada file `.env` menjadi seperti berikut:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=portalberita
   DB_USERNAME="USERNAME DATABASE"
   DB_PASSWORD="PASSWORD DATABASE"
   ```
7. Untuk menggunakan fitur password reset, ubah beberapa konfigurasi yang terdapat pada file `.env` menjadi seperti berikut:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME="EMAIL YANG DIGUNAKAN"
   MAIL_PASSWORD="PASSWORD UNTUK EMAIL YANG DIGUNAKAN"
   MAIL_ENCRYPTION=ssl
   MAIL_FROM_ADDRESS="EMAIL YANG DIGUNAKAN"
   MAIL_FROM_NAME="${APP_NAME}"
   ```
8. Install aplikasi *Laragon*.
9. Jalankan *Laragon*, kemudian klik tombol *Start* untuk menjalankan server.
10. Setelah itu, jalankan perintah `php artisan migrate:fresh --seed` untuk menjalankan semua migrasi database.
11. Pada direktori `portal-berita`, jalankan perintah `php artisan serve`.
12. Kunjungi URL `localhost:8000` pada browser untuk membuka aplikasi website portal berita.
