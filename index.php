<?php
session_start();

require_once 'connection.php';

function decryptMD5($input) {
    return hash('md5', $input);
}

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $decryptedPassword = decryptMD5($password);

    if (empty($username) || empty($password)) {
        $errorMessage = "Username dan Password harus diisi!";
    } else {
        $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$decryptedPassword'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $role = $row['level'];
            $fullname = $row['fullname'];

            if ($role == 'admin') {
                $_SESSION['fullname'] = $fullname;
                $_SESSION['username'] = $username;
                $_SESSION['level'] = 'admin';
                header("Location: application/dashboard.php");
                exit();
            } else if ($role == 'staff') {
                $_SESSION['fullname'] = $fullname;
                $_SESSION['username'] = $username;
                $_SESSION['level'] = 'staff';
                header("Location: application/dashboard.php");
                exit();
            } else if ($role == 'cashier') {
                $_SESSION['fullname'] = $fullname;
                $_SESSION['username'] = $username;
                $_SESSION['level'] = 'cashier';
                header("Location: application/dashboard.php");
                exit();
            }
        } else {
            $errorMessage = "Username atau Password yang anda masukkan salah!";
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1366">
    <title>Book Store Management System</title>
    <link rel="stylesheet" type="text/css" href="style/index.css">
</head>
<body>
    <div class="container-header">
        <h2>Book Store Management System</h2>
    </div>
    <div class="container-form" id="loginForm">
        <h2>Login</h2>
        <form method="POST">
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <p style="color: #FF0000;"><?php echo $errorMessage; ?></p>
            <div class="reglog-action">
                <button type="submit">Login</button>
                <a href="register.php">Or Register New Account</a>
            </div>
        </form>
    </div>

    <script src="script/script.js"></script>
</body>
</html>
