<?php
session_start();

if (isset($_POST['logout']) && $_POST['logout'] == 1) {
    // Hapus semua data sesi yang ada
    session_destroy();

    // Arahkan pengguna ke halaman login
    header("Location: login.php"); // Ganti dengan lokasi halaman login yang sesuai
    exit;
}
?>
