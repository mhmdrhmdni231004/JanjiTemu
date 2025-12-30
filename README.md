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

   ## Profil Aplikasi

**JanjiTemu** adalah aplikasi web berbasis PHP yang dirancang untuk
memudahkan proses reservasi janji temu dokter secara online.
Aplikasi ini membantu pasien dan pihak klinik dalam mengelola
jadwal pemeriksaan secara lebih efisien dan terstruktur.

<img width="1919" height="911" alt="Screenshot 2025-12-30 224844" src="https://github.com/user-attachments/assets/b8665a53-fd2d-4eba-bde4-dc7b66260e35" />

## Alur Penggunaan Aplikasi

### 1. Halaman Pendaftaran
Pengguna diwajibkan melakukan pendaftaran akun terlebih dahulu
dengan mengisi data yang diperlukan agar dapat mengakses sistem.
<img width="1919" height="915" alt="Screenshot 2025-12-31 010013" src="https://github.com/user-attachments/assets/f11d7d71-dd05-4b8e-95a8-1d0a6ea79329" />

### 2. Halaman Login
Setelah berhasil mendaftar, pengguna dapat masuk ke aplikasi
menggunakan email dan password yang telah dibuat.
<img width="1919" height="925" alt="image" src="https://github.com/user-attachments/assets/a25f270c-5a18-4d9a-9a05-9e0daac1fffa" />

### 3. Halaman Dokter
Halaman ini digunakan oleh dokter untuk melihat jadwal praktik,
daftar pasien, serta informasi janji temu yang telah dipesan.
<img width="1919" height="910" alt="Screenshot 2025-12-31 010832" src="https://github.com/user-attachments/assets/adc742f0-1741-4768-abfc-999f2efbe131" />

### 4. Halaman Pasien
Halaman pasien digunakan untuk melihat jadwal dokter, melakukan
pemesanan janji temu, serta memantau status reservasi.
<img width="1915" height="918" alt="image" src="https://github.com/user-attachments/assets/4f274a86-0d88-481c-bdc3-0a81f36c5ed5" />


### 5. Halaman Admin
Halaman admin berfungsi untuk mengelola data pengguna, dokter,
pasien, serta pengaturan jadwal dan sistem aplikasi.
<img width="1919" height="920" alt="image" src="https://github.com/user-attachments/assets/8c1de4b5-2f51-457c-bc34-6ea62742290e" />


   
