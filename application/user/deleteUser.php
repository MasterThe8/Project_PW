<?php
session_start();

require_once '../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST);

    $userCode = $_POST['userCodeDelete'];

    $sql = "DELETE FROM user WHERE user_code = '$userCode'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("User berhasil dihapus!"); window.location.href = "user.php";</script>';
    } else {
        echo '<script>alert("Terjadi kesalahan saat menghapus User!"); window.location.href = "user.php";</script>';
    }
}

$conn->close();
?>
