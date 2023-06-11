<?php
session_start();

require_once '../../connection.php';

// var_dump($_POST);

$bookCode = $_POST['bookCodeEdit'];
$bookName = $_POST['bookNameEdit'];
$bookYear = $_POST['bookYearEdit'];
$bookPrice = $_POST['bookPriceEdit'];
$bookCategory = $_POST['bookCategoryEdit'];
$bookPublisher = $_POST['bookPublisherEdit'];
$bookWriter = $_POST['bookWriterEdit'];
$bookStock = $_POST['bookStockEdit'];
$bookImg = $_POST['bookImgEdit'];

// $sql = "UPDATE book_category SET category_name = '$categoryName' WHERE category_code = '$categoryCode'";
$sql = "UPDATE book SET
    book_title = '$bookName',
    year = '$bookYear',
    category_code = '$bookCategory',
    price = '$bookPrice',
    book_img = '$bookImg',
    publisher = '$bookPublisher',
    writer = '$bookWriter',
    stock = '$bookStock'
    WHERE book_code = '$bookCode'";

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Buku berhasil diedit!"); window.location.href = "book.php";</script>';
} else {
    echo '<script>alert("Terjadi kesalahan saat mengedit buku!"); window.location.href = "book.php";</script>';
}

$conn->close();
?>
