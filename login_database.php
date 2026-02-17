<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUser = $_POST['username'];
    $inputPass = $_POST['password'];

    // 1. Ambil data dari file JSON
    $data = file_get_contents("login_database_pengisi.json");
    $users = json_decode($data, true);

    $login_sukses = false;

    // 2. Loop untuk mengecek kecocokan
    foreach ($users as $user) {
        if ($user['No_ID'] === $inputUser && $user['password'] === $inputPass) {
            $login_sukses = true;
            break;
        }
    }

    // 3. Redirect berdasarkan hasil
    if ($login_sukses) {
        header("Location: login_succ.html");
        exit();
    } else {
        echo "<script>alert('ID atau Password salah!'); window.location.href='index.html';</script>";
    }
}
?>