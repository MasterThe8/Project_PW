<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ci_bsms_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

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
            header("Location: application/dasboard.php");
            exit();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <script src="script/index.js"></script>
</body>
</html>
