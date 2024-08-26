<?php

require_once __DIR__ . '/../vendor/autoload.php';

use laundry\Controller\CustomerController;
use laundry\Controller\TransaksiController;
use laundry\App\Router;
use laundry\Config\Database;
use laundry\Controller\CaptchaController;
use laundry\Controller\HomeController;
use laundry\Controller\pengaturancontroller;
use laundry\Controller\UserController;
use laundry\Middleware\MustNotLoginMiddleware;
use laundry\Middleware\MustLoginMiddleware;

Database::getConnection('test');

// Home Controller
Router::add('GET', '/', HomeController::class, 'index', []);

// User Controller
Router::add('GET', '/users/register', UserController::class, 'register', [MustNotLoginMiddleware::class]);
Router::add('POST', '/users/register', UserController::class, 'postRegister', [MustNotLoginMiddleware::class]);
Router::add('GET', '/users/login', UserController::class, 'login', [MustNotLoginMiddleware::class]);
Router::add('POST', '/users/login', UserController::class, 'postLogin', [MustNotLoginMiddleware::class]);
Router::add('GET', '/users/logout', UserController::class, 'logout', [MustLoginMiddleware::class]);

//Customer Controller
Router::add('POST', '/admin/tambah', CustomerController::class, 'postSave', [MustLoginMiddleware::class]);
Router::add('GET', '/admin/dashboard', CustomerController::class, 'tampil', [MustLoginMiddleware::class]);
Router::add('PUT', '/admin/edit', CustomerController::class, 'postEdit', [MustLoginMiddleware::class]);
Router::add('DELETE', '/admin/hapus', CustomerController::class, 'hapus', [MustLoginMiddleware::class]);
Router::add('POST', '/admin/transaksi', TransaksiController::class, 'postTransaksi', [MustLoginMiddleware::class]);
Router::add('GET', '/admin/pembayaran', TransaksiController::class, 'pembayaran', [MustLoginMiddleware::class]);


//pengaturan controller
Router::add('PUT', '/pengaturan/mengedit', pengaturancontroller::class, 'mengedit', [MustLoginMiddleware::class]);
Router::add('POST', '/mencetak/semuatransaksi', TransaksiController::class, 'ambilsesuai', [MustLoginMiddleware::class]);
Router::add('GET', '/admin/satutransaksi', TransaksiController::class, 'ambil', [MustLoginMiddleware::class]);
Router::add('PUT', '/admin/updatestatus', TransaksiController::class, 'updatestatus', [MustLoginMiddleware::class]);

Router::add('GET', '/admin/verifikasi', UserController::class, 'verifikasi', []);

Router::run();
