<?php
session_start();

require_once '../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryCode = $_POST['categoryCodeAdd'];
    $categoryName = $_POST['categoryNameAdd'];

    // Periksa apakah kode kategori sudah ada
    $checkSql = "SELECT * FROM book_category WHERE category_code = '$categoryCode'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo '<script>alert("Kode kategori sudah ada. Silakan gunakan kode yang lain."); window.location.href = "category.php";</script>';
    } else {
        $insertSql = "INSERT INTO book_category (category_code, category_name) VALUES ('$categoryCode', '$categoryName')";

        if ($conn->query($insertSql) === TRUE) {
            echo '<script>alert("Kategori berhasil ditambahkan!"); window.location.href = "category.php";</script>';
        } else {
            echo '<script>alert("Terjadi kesalahan saat menambahkan kategori, periksa kembali inputan anda!"); window.location.href = "category.php";</script>';
        }
    }
}

$conn->close();
?>
