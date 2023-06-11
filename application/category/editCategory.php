<?php
session_start();

require_once '../../connection.php';

$categoryCode = $_POST['categoryCodeEdit'];
$categoryName = $_POST['categoryNameEdit'];

$sql = "UPDATE book_category SET category_name = '$categoryName' WHERE category_code = '$categoryCode'";

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Kategori berhasil diedit!"); window.location.href = "category.php";</script>';
} else {
    echo '<script>alert("Terjadi kesalahan saat mengedit kategori!"); window.location.href = "category.php";</script>';
}

$conn->close();
?>
