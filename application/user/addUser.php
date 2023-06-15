<?php
session_start();

require_once '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['UserFullnameAdd'];
    $username = $_POST['UsernameAdd'];
    $password = $_POST['UserPasswordAdd'];
    $level = $_POST['UserLevelAdd'];

    $encryptedPassword = md5($password);

    $sqluser = "SELECT user_code FROM user ORDER BY user_code DESC LIMIT 1";
    $result = $conn->query($sqluser);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastUserCode = $row["user_code"];

        $newUserCode = $lastUserCode + 1;
    } else {
        $newUserCode = 1;
    }

    if ($level === null || !in_array($level, ['admin', 'staff', 'cashier'])) {
        echo '<script>alert("Menambah User Baru Gagal!, Mohon Memilih Role Yang Benar!"); window.location.href = "user.php";</script>';
        return;
    }

    $sql = "INSERT INTO user (user_code, fullname, username, password, level) VALUES ('$newUserCode', '$fullname', '$username', '$encryptedPassword', '$level')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("User Berhasil Ditambahkan!"); window.location.href = "user.php";</script>';
    } else {
        echo '<script>alert("Terjadi masalah, periksa kembali inputan Anda!"); window.location.href = "user.php";</script>';
    }

    $conn->close();
}
?>