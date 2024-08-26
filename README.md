sebelum menjalankan perogram 
1. instal composer
2. instal library PHPMailer composer require phpmailer/phpmailer
3. instal library gregwar/captcha composer require gregwar/captcha
4. instal library firebase/php-jwt composer require firebase/php-jwt
5. instal library dompdf composer require dompdf/dompdf

cara penggunaan

Berikut adalah dokumentasi untuk metode-metode dalam controller PHP kamu. Dokumentasi ini mencakup deskripsi, parameter, respons, dan alur kerja untuk setiap metode.

---

## Dokumentasi API

### 1. `register()`

**Deskripsi:**
Metode ini menghasilkan CAPTCHA untuk pendaftaran pengguna baru. CAPTCHA disajikan sebagai gambar JPEG dan disimpan dalam sesi untuk validasi.

**Endpoint:**
- **URL**: `/users/register`
- **Method**: GET
- **Content-Type**: image/jpeg

**Header yang Ditetapkan:**
- `Content-Type: image/jpeg` - Menetapkan tipe konten respons sebagai gambar JPEG.
- `Access-Control-Allow-Methods: GET` - Mengizinkan metode GET dalam permintaan CORS.
- `Access-Control-Allow-Origin: *` - Mengizinkan akses dari semua sumber untuk permintaan CORS.

**Respons:**
- **Content-Type**: image/jpeg
  - Gambar CAPTCHA dalam format JPEG.

**Alur Kerja:**
1. Inisialisasi `CaptchaBuilder` dan bangun CAPTCHA.
2. Simpan frase CAPTCHA di sesi untuk validasi.
3. Output CAPTCHA sebagai gambar JPEG.

---

### 2. `postRegister()`

**Deskripsi:**
Metode ini menangani permintaan POST untuk mendaftar pengguna baru dengan memproses data pendaftaran, termasuk CAPTCHA. Jika pendaftaran berhasil, sistem akan memberikan pesan bahwa pendaftaran menunggu aktivasi admin.

**Endpoint:**
- **URL**: `/users/register`
- **Method**: POST
- **Content-Type**: application/json

**Header yang Ditetapkan:**
- `Content-Type: application/json` - Menetapkan tipe konten respons sebagai JSON.
- `Access-Control-Allow-Methods: POST` - Mengizinkan metode POST dalam permintaan CORS.
- `Access-Control-Allow-Origin: *` - Mengizinkan akses dari semua sumber untuk permintaan CORS.

**Parameter Input:**
- **id** (string): ID pengguna.
- **name** (string): Nama pengguna.
- **captcha** (string): Kode CAPTCHA dari formulir.
- **password** (string): Kata sandi pengguna.

**Respons:**
- **200 OK**:
  ```json
  {
      "message": "menunggu admin mengaktifkan akun"
  }
  ```
- **400 Bad Request** (Jika ada pengecualian `ValidationException`):
  ```json
  {
      "message": "Pesan kesalahan validasi yang spesifik"
  }
  ```

**Alur Kerja:**
1. Ambil data dari permintaan POST dan buat objek `UserRegisterRequest`.
2. Tambahkan kode verifikasi acak.
3. Panggil metode `register` pada `userService` untuk memproses pendaftaran.
4. Kirim respons JSON sesuai hasil.

---

### 3. `verifikasi()`

**Deskripsi:**
Metode ini menangani verifikasi pengguna dengan menggunakan kode verifikasi yang diterima. Setelah verifikasi berhasil, sistem akan memberikan pesan konfirmasi.

**Endpoint:**
- **URL**: `/admin/verifikasi?verifikasi=kodeverifikasiakun`
- **Method**: POST
- **Content-Type**: application/json

**Header yang Ditetapkan:**
- `Content-Type: application/json` - Menetapkan tipe konten respons sebagai JSON.
- `Access-Control-Allow-Methods: POST` - Mengizinkan metode POST dalam permintaan CORS.
- `Access-Control-Allow-Origin: *` - Mengizinkan akses dari semua sumber untuk permintaan CORS.

**Parameter Input:**
- **verifikasi** (string): Kode verifikasi dari URL parameter `GET`.

**Respons:**
- **200 OK**:
  ```json
  {
      "message": "verifikasi berhasil"
  }
  ```
- **400 Bad Request** (Jika terjadi kesalahan):
  ```json
  {
      "message": "verifikasi gagal",
      "error": "Pesan kesalahan spesifik"
  }
  ```

**Alur Kerja:**
1. Ambil kode verifikasi dari parameter `GET` dan panggil metode `verifikasi` pada `userService`.
2. Kirim respons JSON sesuai hasil verifikasi.

---

### 4. `login()`

**Deskripsi:**
Metode ini menghasilkan CAPTCHA untuk login pengguna. CAPTCHA disajikan sebagai gambar JPEG dan disimpan dalam sesi untuk validasi.

**Endpoint:**
- **URL**: `/users/login`
- **Method**: GET
- **Content-Type**: image/jpeg

**Header yang Ditetapkan:**
- `Content-Type: image/jpeg` - Menetapkan tipe konten respons sebagai gambar JPEG.
- `Access-Control-Allow-Methods: GET` - Mengizinkan metode GET dalam permintaan CORS.
- `Access-Control-Allow-Origin: *` - Mengizinkan akses dari semua sumber untuk permintaan CORS.

**Respons:**
- **Content-Type**: image/jpeg
  - Gambar CAPTCHA dalam format JPEG.

**Alur Kerja:**
1. Inisialisasi `CaptchaBuilder` dan bangun CAPTCHA.
2. Simpan frase CAPTCHA di sesi untuk validasi.
3. Output CAPTCHA sebagai gambar JPEG.

---

### 5. `postLogin()`

**Deskripsi:**
Metode ini menangani permintaan POST untuk login pengguna. Metode ini memproses data login, termasuk CAPTCHA, dan memberikan umpan balik ke klien.

**Endpoint:**
- **URL**: `/users/login`
- **Method**: POST
- **Content-Type**: application/json

**Header yang Ditetapkan:**
- `Content-Type: application/json` - Menetapkan tipe konten respons sebagai JSON.
- `Access-Control-Allow-Methods: POST` - Mengizinkan metode POST dalam permintaan CORS.
- `Access-Control-Allow-Origin: *` - Mengizinkan akses dari semua sumber untuk permintaan CORS.

**Parameter Input:**
- **id** (string): ID pengguna.
- **password** (string): Kata sandi pengguna.
- **captcha** (string): Kode CAPTCHA dari formulir.

**Respons:**
- **200 OK**:
  ```json
  {
      "message": "berhasil login"
  }
  ```
- **400 Bad Request** (Jika ada pengecualian `ValidationException`):
  ```json
  {
      "message": "gagal login",
      "pesan": "Pesan kesalahan spesifik"
  }
  ```

**Alur Kerja:**
1. Ambil data dari permintaan POST dan buat objek `UserLoginRequest`.
2. Panggil metode `login` pada `userService` dan buat sesi jika login berhasil.
3. Kirim respons JSON sesuai hasil login.

---

### 6. `logout()`

**Deskripsi:**
Metode ini menangani logout pengguna dengan menghancurkan sesi pengguna dan mengarahkan ke halaman beranda.

**Endpoint:**
- **URL**: `/users/logout`
- **Method**: GET

**Alur Kerja:**
1. Hancurkan sesi pengguna menggunakan `sessionService`.
2. Arahkan pengguna ke halaman beranda ("/").

---

Dengan dokumentasi ini, pengembang dan pengguna API dapat memahami cara menggunakan berbagai metode di controller, parameter yang diperlukan, dan apa yang diharapkan sebagai hasil dari setiap permintaan.


