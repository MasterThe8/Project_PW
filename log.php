<?php
session_start();

// Periksa apakah pengguna sudah login dan memiliki session role
if (isset($_SESSION['log']) && $_SESSION['log'] === 'Logged' && isset($_SESSION['level'])) {
    $role = $_SESSION['level'];

    // Periksa role untuk menentukan hak akses halaman
    if ($role === 'admin') {
        // Aksi atau tampilan khusus untuk role Admin
        echo "Selamat datang, Admin!";
        // ...
    } else if ($role === 'staff') {
        // Aksi atau tampilan khusus untuk role Staff
        echo "Selamat datang, Staff!";
        // ...
    } else if ($role === 'cashier') {
        // Aksi atau tampilan khusus untuk role Cashier
        echo "Selamat datang, Cashier!";
        // ...
    } else {
        // Jika role tidak sesuai, misalnya jika tidak ada role yang ditemukan
        echo "Role tidak valid!";
    }
} else {
    // Jika pengguna belum login atau session role tidak ada
    echo "Anda belum login!";
    // Anda bisa melakukan redirect ke halaman login atau melakukan aksi lainnya
    // header("Location: login.php");
}
?>
