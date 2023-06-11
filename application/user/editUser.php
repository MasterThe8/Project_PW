<?php
session_start();

require_once '../../connection.php';

$userCode = $_POST['userCodeEdit'];
$userFullname = $_POST['userFullnameEdit'];
$username = $_POST['usernameEdit'];
$userPassword = $_POST['userPasswordEdit'];
$userLevel = $_POST['userLevelEdit'];

$encryptedPassword = md5($userPassword);

$sql = "UPDATE user SET
    fullname = '$userFullname',
    username = '$username',
    password = '$encryptedPassword',
    level = '$userLevel'
    WHERE user_code = '$userCode'
    ";

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("User berhasil diedit!"); window.location.href = "user.php";</script>';
} else {
    echo '<script>alert("Terjadi kesalahan saat mengedit User!"); window.location.href = "user.php";</script>';
}

$conn->close();
?>
