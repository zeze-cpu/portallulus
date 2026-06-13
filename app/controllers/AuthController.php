<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

final class AuthController
{
  public function showLogin(): void
  {
    if (is_logged_in()) {
      $role = $_SESSION['user']['role'] ?? 'admin';
      redirect($role === 'siswa' ? '/siswa/dashboard' : '/admin');
    }
    view('auth/login', ['title' => 'Login - PortalLulus', 'layout' => 'auth']);
  }

  public function login(): void
  {
    csrf_verify();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
      view('auth/login', ['title' => 'Login - PortalLulus', 'layout' => 'auth', 'error' => 'Username dan password wajib diisi.']);
      return;
    }

    $pdo  = Database::pdo();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND is_active = 1 LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
      view('auth/login', ['title' => 'Login - PortalLulus', 'layout' => 'auth', 'error' => 'Username atau password salah.']);
      return;
    }

    session_regenerate_id(true);
    $_SESSION['user'] = [
      'id'       => $user['id'],
      'username' => $user['username'],
      'nama'     => $user['nama'],
      'role'     => $user['role'],
    ];
    redirect('/admin');
  }

  public function showLoginSiswa(): void
  {
    if (is_logged_in()) redirect('/siswa/dashboard');
    view('auth/login_siswa', ['title' => 'Login Siswa', 'layout' => 'auth']);
  }

  public function loginSiswa(): void
  {
    csrf_verify();

    $nisn = trim($_POST['nisn'] ?? '');

    if ($nisn === '') {
      view('auth/login_siswa', ['title' => 'Login Siswa', 'layout' => 'auth', 'error' => 'NISN wajib diisi.']);
      return;
    }

    $pdo  = Database::pdo();
    $stmt = $pdo->prepare("SELECT * FROM siswa WHERE nisn = ? AND is_active = 1 LIMIT 1");
    $stmt->execute([$nisn]);
    $siswa = $stmt->fetch();

    if (!$siswa) {
      view('auth/login_siswa', ['title' => 'Login Siswa', 'layout' => 'auth', 'error' => 'Data tidak ditemukan. Pastikan NISN yang dimasukkan benar.']);
      return;
    }

    session_regenerate_id(true);
    $_SESSION['user'] = [
      'id'    => $siswa['id'],
      'nama'  => $siswa['nama'],
      'role'  => 'siswa',
      'nisn'  => $siswa['nisn'],
    ];

    redirect('/siswa/dashboard');
  }

  public function logout(): void
  {
    csrf_verify();
    session_destroy();
    redirect('/login');
  }

  public function showChangePassword(): void
  {
    require_login();
    redirect('/admin/profil');
  }

  public function changePassword(): void
  {
    require_login();
    csrf_verify();

    $old    = $_POST['old_password']     ?? '';
    $new    = $_POST['new_password']     ?? '';
    $repeat = $_POST['repeat_password']  ?? '';

    if ($new !== $repeat) {
      $_SESSION['pw_error'] = 'Konfirmasi kata sandi tidak cocok.';
      redirect('/admin/profil');
      return;
    }

    $policyError = password_policy_error($new);
    if ($policyError) {
      $_SESSION['pw_error'] = $policyError;
      redirect('/admin/profil');
      return;
    }

    $pdo  = Database::pdo();
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user']['id']]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($old, $user['password'])) {
      $_SESSION['pw_error'] = 'Kata sandi lama yang Anda masukkan salah.';
      redirect('/admin/profil');
      return;
    }

    $hash = password_hash($new, PASSWORD_DEFAULT);
    $pdo->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$hash, $_SESSION['user']['id']]);

    $_SESSION['flash'] = 'Kata sandi berhasil diperbarui.';
    redirect('/admin/profil');
  }

  public function showProfile(): void
  {
    require_login();
    $pdo = Database::pdo();
    $stmt = $pdo->prepare("SELECT username, nama FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user']['id']]);
    $user = $stmt->fetch();

    // Ambil error kata sandi dari session jika ada
    $error = $_SESSION['pw_error'] ?? null;
    unset($_SESSION['pw_error']);

    view('auth/profil', [
      'title' => 'Profil Saya',
      'user'  => $user,
      'error' => $error,
    ]);
  }

  public function updateProfile(): void
  {
    require_login();
    csrf_verify();

    $username = trim($_POST['username'] ?? '');
    $nama     = trim($_POST['nama'] ?? '');

    if ($username === '' || $nama === '') {
      $_SESSION['flash_error'] = 'Nama dan Username wajib diisi.';
      redirect('/admin/profil');
      return;
    }

    $pdo = Database::pdo();
    
    // Check if username is already taken by another user
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
    $stmt->execute([$username, $_SESSION['user']['id']]);
    if ($stmt->fetch()) {
      $_SESSION['flash_error'] = 'Username sudah digunakan oleh orang lain.';
      redirect('/admin/profil');
      return;
    }

    $stmt = $pdo->prepare("UPDATE users SET username = ?, nama = ? WHERE id = ?");
    $stmt->execute([$username, $nama, $_SESSION['user']['id']]);

    // Update session
    $_SESSION['user']['username'] = $username;
    $_SESSION['user']['nama']     = $nama;

    $_SESSION['flash'] = 'Profil berhasil diperbarui.';
    redirect('/admin/profil');
  }
}
