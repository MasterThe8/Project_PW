<?php
session_start();

require_once '../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookCode = $_POST['bookCodeDelete'];

    $sql = "DELETE FROM book WHERE book_code = '$bookCode'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Buku berhasil dihapus!"); window.location.href = "book.php";</script>';
    } else {
        echo '<script>alert("Terjadi kesalahan saat menghapus buku!"); window.location.href = "book.php";</script>';
    }
}

$conn->close();
?>
