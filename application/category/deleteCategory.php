<?php
session_start();

require_once '../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryCode = $_POST['categoryCodeDelete'];

    $sql = "DELETE FROM book_category WHERE category_code = '$categoryCode'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Kategori berhasil dihapus!"); window.location.href = "category.php";</script>';
    } else {
        echo '<script>alert("Terjadi kesalahan saat menghapus kategori!"); window.location.href = "category.php";</script>';
    }
}

$conn->close();
?>
