<?php
session_start();

require_once '../../connection.php';

var_dump($_POST);

$bookCode = $_POST['bookCodeEdit'];
$bookName = $_POST['bookNameEdit'];
$bookYear = $_POST['bookYearEdit'];
$bookPrice = $_POST['bookPriceEdit'];
$bookCategory = $_POST['bookCategoryEdit'];
$bookPublisher = $_POST['bookPublisherEdit'];
$bookWriter = $_POST['bookWriterEdit'];
$bookStock = $_POST['bookStockEdit'];

if (isset($_FILES['bookImgEdit']) && $_FILES['bookImgEdit']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['bookImgEdit'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $uploadDirectory = 'img/';

    $newFileName = uniqid('', true) . '.' . $fileExt;

    $destination = $uploadDirectory . $newFileName;
    move_uploaded_file($fileTmpName, $destination);

    // Menggunakan variabel $destination sebagai nilai $bookImg
    $bookImg = $destination;
} else {
    // window.location.href = "book.php";
    echo '<script>alert("Gambar tidak diunggah atau terjadi kesalahan saat mengunggah gambar."); </script>';
}

$checkSql = "SELECT * FROM book WHERE book_code = '$bookCode'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows > 0) {
    // window.location.href = "book.php";
    echo '<script>alert("Kode buku sudah ada. Silakan gunakan kode yang lain."); </script>';
} else {
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
}


$conn->close();
?>
