# JanjiTemu2
JanjiTemu adalah aplikasi web sistem informasi klinik yang dirancang untuk memfasilitasi reservasi janji temu dokter secara online. Aplikasi ini membantu pasien, dokter, dan pihak klinik dalam mengelola jadwal pemeriksaan dengan lebih efisien, terstruktur, dan terkomputerisasi.

## Instalasi

Untuk menjalankan **JanjiTemu** secara lokal, siapkan lingkungan berikut:
1. **PHP & Web Server**  
   Gunakan XAMPP dengan versi PHP **7.x atau 8.x**.  
   Aplikasi ini berbasis PHP dan **tidak memerlukan Node.js**.
2. **Database**  
   MySQL atau MariaDB.
   
## Langkah Instalasi
1. Ekstrak atau salin folder proyek **JanjiTemu** ke dalam folder web server  
   (contoh: `htdocs/janjitemu` pada XAMPP).
2. Buat database baru melalui **phpMyAdmin** atau MySQL CLI  
   (contoh: dengan nama database `janjitemu`).
3. Import file database `.sql` yang tersedia di folder proyek ke database tersebut.  
   File ini akan membuat tabel dan data awal yang diperlukan.
4. Buka file konfigurasi koneksi database, misalnya:
   - `connection.php`  
   - atau file di dalam folder `includes/`
   Sesuaikan pengaturan database (`host`, `username`, `password`, dan `nama database`)  
   sesuai dengan konfigurasi server lokal Anda  
   (default MySQL lokal biasanya `root` tanpa password).
5. Jalankan web server, kemudian buka browser dan akses aplikasi melalui: http://localhost/janji-temu2 (atau alamat lain yang sesuai dengan folder instalasi Anda.)
<img width="1919" height="911" alt="Screenshot 2025-12-30 224844" src="https://github.com/user-attachments/assets/b8665a53-fd2d-4eba-bde4-dc7b66260e35" />

   
