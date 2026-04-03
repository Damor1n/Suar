<?php
session_start();

// Safe check for request method to avoid undefined index warnings
$method = $_SERVER['REQUEST_METHOD'] ?? '';
if ($method === 'POST') {
    // Validate POST inputs exist
    if (!isset($_POST['username'], $_POST['password'])) {
        echo "<script>alert('Form tidak lengkap.'); window.location.href='frontend.html';</script>";
        exit();
    }

    $inputUser = trim($_POST['username']);
    $inputPass = trim($_POST['password']);

    // 1. Ambil data dari file JSON (use absolute path relative to this script)
    $jsonFile = __DIR__ . '/login_database_pengisi.json';
    if (!file_exists($jsonFile)) {
        error_log("login_database: JSON file not found: $jsonFile");
        echo "<script>alert('Internal error: user database tidak ditemukan.'); window.location.href='frontend.html';</script>";
        exit();
    }

    $data = file_get_contents($jsonFile);
    $users = json_decode($data, true);
    if ($users === null && json_last_error() !== JSON_ERROR_NONE) {
        error_log('login_database: json_decode error: ' . json_last_error_msg());
        echo "<script>alert('Internal error membaca database.'); window.location.href='frontend.html';</script>";
        exit();
    }

    $login_sukses = false;

    // 2. Loop untuk mengecek kecocokan
    foreach ($users as $user) {
        if (isset($user['No_ID'], $user['password']) && $user['No_ID'] === $inputUser && $user['password'] === $inputPass) {
            $login_sukses = true;
            $_SESSION['No_ID'] = $user['No_ID'];
            $_SESSION['nama_akun'] = $user['Nama'] ?? $user['No_ID'];
            break;
        }
    }

    // 3. Redirect berdasarkan hasil (no output before header)
    if ($login_sukses) {
        header('Location: login_success.html');
        exit();
    } else {
        echo "<script>alert('ID atau Password salah!'); window.location.href='login_page.html';</script>";
        exit();
    }
}
?>