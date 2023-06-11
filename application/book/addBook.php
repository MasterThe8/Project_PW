<?php
session_start();

require_once '../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST);

    $bookCode = $_POST['bookCodeAdd'];
    $bookName = $_POST['bookNameAdd'];
    $bookYear = $_POST['bookYearAdd'];
    $bookPrice = $_POST['bookPriceAdd'];
    $bookCategory = $_POST['bookCategoryAdd'];
    $bookPublisher = $_POST['bookPublisherAdd'];
    $bookWriter = $_POST['bookWriterAdd'];
    $bookStock = $_POST['bookStockAdd'];

    if (isset($_FILES['bookImgAdd']) && $_FILES['bookImgAdd']['error'] === UPLOAD_ERR_OK) {
        // Mendapatkan informasi file gambar yang diupload
        $file = $_FILES['bookImgAdd'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        // Memisahkan ekstensi file
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Definisikan direktori penyimpanan
        $uploadDirectory = 'img/';

        // Definisikan nama file baru dengan nama unik
        $newFileName = uniqid('', true) . '.' . $fileExt;

        // Pindahkan file ke direktori penyimpanan
        $destination = $uploadDirectory . $newFileName;
        move_uploaded_file($fileTmpName, $destination);
    } else {
        echo "Gambar tidak diunggah atau terjadi kesalahan saat mengunggah gambar.";
        // Anda bisa menambahkan tindakan lain yang sesuai dengan kebutuhan Anda jika gambar tidak diunggah
    }

    $checkSql = "SELECT * FROM book WHERE book_code = '$bookCode'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo "Kode buku sudah ada. Silakan gunakan kode yang lain.";
    } else {
        $insertSql = "INSERT INTO book (book_code, book_title, year, category_code, price, book_img, publisher, writer, stock) VALUES ('$bookCode', '$bookName', '$bookYear', '$bookCategory', '$bookPrice', '$newFileName', '$bookPublisher', '$bookWriter', '$bookStock')";

        if ($conn->query($insertSql) === TRUE) {
            echo '<script>alert("Buku berhasil ditambahkan!"); window.location.href = "book.php";</script>';
        } else {
            echo '<script>alert("Terjadi kesalahan saat menambahkan buku, periksa kembali inputan anda!"); window.location.href = "book.php";</script>';
        }
    }
}

$conn->close();
?>
