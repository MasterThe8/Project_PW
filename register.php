<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'connection.php';

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

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
        echo '<script>alert("Registrasi Gagal!, Mohon Memilih Role Yang Benar!"); window.location.href = "register.php";</script>';
        return;
    }

    $sql = "INSERT INTO user (user_code, fullname, username, password, level) VALUES ('$newUserCode', '$fullname', '$username', '$encryptedPassword', '$level')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Registrasi Berhasil! Silahkan Login."); window.location.href = "index.php";</script>';
    } else {
        echo '<script>alert("Terjadi masalah, periksa kembali inputan Anda!"); window.location.href = "register.php";</script>';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1366">
    <title>Register - BSMS</title>
    <link rel="stylesheet" type="text/css" href="style/index.css">
</head>
<body>
    <div class="container-header">
        <h2>Book Store Management System</h2>
    </div>
    <div class="container-form" id="registerForm">
        <h2>Create New Account</h2>
        <form method="POST">
            <div class="form-group">
                <input type="text" id="fullname" name="fullname" placeholder="Fullname" required>
            </div>
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <select type="text" name="level" required="" class="custom-select is-valid" aria-invalid="false">
                    <option class="default-select" selected="" disabled="" hidden="">User Role</option>
                    <option>admin</option>
                    <option>cashier</option>
                    <option>staff</option>
                </select>
            </div>
            <div class="reglog-action">
                <button type="submit">Register</button>
                <span><a href="index.php">Already have an account? Login here</a></span>
            </div>
        </form>
    </div>

    <script>
        <?php if (isset($registrationSuccess) && $registrationSuccess) { ?>
            window.onload = function() {
                alert('Registrasi berhasil!');
                window.location.href = 'index.php';
            };
        <?php } ?>
    </script>
</body>
</html>
