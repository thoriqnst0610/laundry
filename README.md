sebelum menjalankan perogram 
1. instal composer
2. instal library PHPMailer composer require phpmailer/phpmailer
3. instal library gregwar/captcha composer require gregwar/captcha
4. instal library firebase/php-jwt composer require firebase/php-jwt
5. instal library dompdf composer require dompdf/dompdf

cara penggunaan
a. registerasi 

http://localhost:8080/users/register
method = GET

ini untuk mendapatkan gambar captcha

http://localhost:8080/users/register
method = POST

Endpoint
URL: /register
Method: POST
Content-Type: application/json
Header yang Ditetapkan
Content-Type: application/json - Menetapkan tipe konten respons sebagai JSON.
Access-Control-Allow-Methods: POST - Mengizinkan metode POST dalam permintaan CORS.
Access-Control-Allow-Origin: * - Mengizinkan akses dari semua sumber untuk permintaan CORS.
Parameter Input
Metode ini mengharapkan data berikut dari permintaan POST:

id (string): ID pengguna yang ingin didaftarkan.
name (string): Nama pengguna.
captcha (string): Kode CAPTCHA yang diberikan kepada pengguna.
password (string): Kata sandi pengguna yang ingin didaftarkan.

{
    "id": "123",
    "name": "John Doe",
    "captcha": "12345",
    "password": "securepassword"
}

Contoh Respons
Respons Sukses:

{
    "message": "menunggu admin mengaktifkan akun"
}



