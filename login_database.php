<?php
session_start();

$method = $_SERVER['REQUEST_METHOD'] ?? '';
if ($method === 'POST') {
    if (!isset($_POST['username'], $_POST['password'])) {
        echo "<script>alert('Form tidak lengkap.'); window.location.href='frontend.html';</script>";
        exit();
    }

    $inputUser = trim($_POST['username']);
    $inputPass = trim($_POST['password']);

    $jsonFilePengakses = __DIR__ . '/login_database_pengakses.json';
    if (file_exists($jsonFilePengakses)) {
        $dataPengakses = file_get_contents($jsonFilePengakses);
        $usersPengakses = json_decode($dataPengakses, true);
        if ($usersPengakses !== null) {
            foreach ($usersPengakses as $user) {
                if (isset($user['No. ID'], $user['Password']) && $user['No. ID'] === $inputUser && $user['Password'] === $inputPass) {
                    $_SESSION['No_ID'] = $user['No. ID'];
                    $_SESSION['nama_akun'] = $user['Nama'] ?? $user['No. ID'];
                    header('Location: main_menu_admin.html');
                    exit();
                }
            }
        }
    }

    $jsonFilePengisi = __DIR__ . '/login_database_pengisi.json';
    if (!file_exists($jsonFilePengisi)) {
        error_log("login_database: JSON file not found: $jsonFilePengisi");
        echo "<script>alert('Internal error: user database tidak ditemukan.'); window.location.href='login_page.html';</script>";
        exit();
    }

    $dataPengisi = file_get_contents($jsonFilePengisi);
    $usersPengisi = json_decode($dataPengisi, true);
    if ($usersPengisi === null && json_last_error() !== JSON_ERROR_NONE) {
        error_log('login_database: json_decode error: ' . json_last_error_msg());
        echo "<script>alert('Internal error membaca database.'); window.location.href='login_page.html';</script>";
        exit();
    }

    foreach ($usersPengisi as $user) {
        if (isset($user['No_ID'], $user['password']) && $user['No_ID'] === $inputUser && $user['password'] === $inputPass) {
            $_SESSION['No_ID'] = $user['No_ID'];
            $_SESSION['nama_akun'] = $user['Nama'] ?? $user['No_ID'];
            header('Location: main_menu_user.html');
            exit();
        }
    }

    echo "<script>alert('ID atau Password salah!'); window.location.href='login_page.html';</script>";
    exit();
}
?>