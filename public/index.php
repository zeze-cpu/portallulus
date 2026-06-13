<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

use App\Core\Router;
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\KelasController;
use App\Controllers\JurusanController;
use App\Controllers\MapelController;
use App\Controllers\NilaiController;
use App\Controllers\SKLController;
use App\Controllers\SiswaController;
use App\Controllers\ImportController;
use App\Controllers\SiswaDashboardController;

$router = new Router();

// Root route
$router->get('/', function() {
    if (is_logged_in()) {
        $role = $_SESSION['user']['role'] ?? 'admin';
        if ($role === 'siswa') {
            redirect('/siswa/dashboard');
        } else {
            redirect('/admin');
        }
    } else {
        redirect('/siswa/login');
    }
});

// Auth routes
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);
$router->get('/admin/ubah-password', [AuthController::class, 'showChangePassword']);
$router->post('/admin/ubah-password', [AuthController::class, 'changePassword']);
$router->get('/admin/profil', [AuthController::class, 'showProfile']);
$router->post('/admin/profil', [AuthController::class, 'updateProfile']);

// Admin routes
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->post('/admin/proses-kelulusan', [AdminController::class, 'processGraduation']);
$router->get('/admin/dashboard', [AdminController::class, 'dashboard']);

// SKL
$router->get('/admin/skl', [SKLController::class, 'index']);
$router->post('/admin/skl', [SKLController::class, 'store']);
$router->post('/admin/skl/{id}', [SKLController::class, 'update']);

// Jurusan (disembunyikan dari menu, tetapi route tetap tersedia)
$router->get('/admin/jurusan', [JurusanController::class, 'index']);
$router->post('/admin/jurusan', [JurusanController::class, 'store']);
$router->get('/admin/jurusan/{id}/edit', [JurusanController::class, 'edit']);
$router->post('/admin/jurusan/{id}', [JurusanController::class, 'update']);
$router->post('/admin/jurusan/{id}/delete', [JurusanController::class, 'delete']);

// Kelas
$router->get('/admin/kelas', [KelasController::class, 'index']);
$router->post('/admin/kelas', [KelasController::class, 'store']);
$router->get('/admin/kelas/{id}/edit', [KelasController::class, 'edit']);
$router->post('/admin/kelas/{id}', [KelasController::class, 'update']);
$router->post('/admin/kelas/{id}/delete', [KelasController::class, 'delete']);

// Mapel
$router->get('/admin/mapel', [MapelController::class, 'index']);
$router->post('/admin/mapel', [MapelController::class, 'store']);
$router->get('/admin/mapel/{id}/edit', [MapelController::class, 'edit']);
$router->post('/admin/mapel/{id}', [MapelController::class, 'update']);
$router->post('/admin/mapel/{id}/delete', [MapelController::class, 'delete']);

// Siswa
$router->get('/admin/siswa', [SiswaController::class, 'index']);
$router->post('/admin/siswa', [SiswaController::class, 'store']);
$router->get('/admin/siswa/{id}/edit', [SiswaController::class, 'edit']);
$router->post('/admin/siswa/{id}', [SiswaController::class, 'update']);
$router->post('/admin/siswa/{id}/delete', [SiswaController::class, 'delete']);

// Nilai
$router->get('/admin/nilai', [NilaiController::class, 'index']);
$router->get('/admin/nilai/{id}', [NilaiController::class, 'show']);
$router->post('/admin/nilai', [NilaiController::class, 'store']);
$router->post('/admin/nilai/{id}/delete', [NilaiController::class, 'delete']);

// Import
$router->post('/admin/import/siswa', [ImportController::class, 'siswa']);
$router->post('/admin/import/nilai', [ImportController::class, 'nilai']);
$router->post('/admin/import/jurusan', [ImportController::class, 'jurusan']);
$router->get('/admin/import/siswa/template', [ImportController::class, 'templateSiswa']);
$router->get('/admin/import/nilai/template', [ImportController::class, 'templateNilaiPrefilled']);
$router->get('/admin/import/jurusan/template', [ImportController::class, 'templateJurusan']);

// Siswa
$router->get('/siswa/login', [AuthController::class, 'showLoginSiswa']);
$router->post('/siswa/login', [AuthController::class, 'loginSiswa']);
$router->get('/siswa/dashboard', [SiswaDashboardController::class, 'index']);
$router->get('/siswa/cetak-skl', [SiswaDashboardController::class, 'downloadSKL']);

$router->dispatch();
