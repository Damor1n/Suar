<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Isi_pesan_page.php');
    exit();
}

session_start();
$namaAkun = trim($_SESSION['nama_akun'] ?? 'Anonymous');
$pesan = trim($_POST['message'] ?? '');

if ($namaAkun === '' || $pesan === '') {
    echo "<script>alert('Nama akun dan pesan wajib diisi.'); window.location.href='Isi_pesan_page.html';</script>";
    exit();
}

$localTime = trim($_POST['local_time'] ?? '');
if ($localTime === '') {
    $localTime = date('d-m-Y H:i:s');
}

$entry = [
    'nama_akun' => $namaAkun,
    'waktu' => $localTime,
    'pesan' => $pesan,
];

$file = __DIR__ . '/pesan_database.json';
if (!file_exists($file)) {
    file_put_contents($file, "[]");
}

$data = file_get_contents($file);
$messages = json_decode($data, true);
if (!is_array($messages)) {
    $messages = [];
}

$messages[] = $entry;
file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "<script>alert('Pesan berhasil disimpan!'); window.location.href='main_menu_user.html';</script>";
exit();
