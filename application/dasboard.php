<?php
session_start();

require_once '../connection.php';

    $sqlBuku = "SELECT COUNT(*) AS total_book FROM book";
    $resultBuku = $conn->query($sqlBuku);
    if ($resultBuku->num_rows > 0) {
        $row = $resultBuku->fetch_assoc();
        $totalBook = $row["total_book"];
    } else {
        $totalBook = 0;
    }

    $sqlEarn = "SELECT SUM(total) AS total_earn FROM transaction";
    $resultEarn = $conn->query($sqlEarn);
    if ($resultEarn->num_rows > 0) {
        $row = $resultEarn->fetch_assoc();
        $totalEarn = $row["total_earn"];
    } else {
        $totalEarn = 0;
    }

    $sqlCategory = "SELECT COUNT(*) AS total_category FROM book_category";
    $resultCategory = $conn->query($sqlCategory);
    if ($resultCategory->num_rows > 0) {
        $row = $resultCategory->fetch_assoc();
        $totalCategory = $row["total_category"];
    } else {
        $totalCategory = 0;
    }

    $sqlStock = "SELECT SUM(stock) AS total_stock FROM book";
    $resultStock = $conn->query($sqlStock);
    if ($resultStock->num_rows > 0) {
        $row = $resultStock->fetch_assoc();
        $totalStock = $row["total_stock"];
    } else {
        $totalStock = 0;
    }

    $sqlTransaction = "SELECT COUNT(*) AS total_transaction FROM transaction";
    $resultTransaction = $conn->query($sqlTransaction);
    if ($resultTransaction->num_rows > 0) {
        $row = $resultTransaction->fetch_assoc();
        $totalTransaction = $row["total_transaction"];
    } else {
        $totalTransaction = 0;
    }

    $sqlUserSystem = "SELECT COUNT(*) AS total_usersystem FROM user";
    $resultUserSystem = $conn->query($sqlUserSystem);
    if ($resultUserSystem->num_rows > 0) {
        $row = $resultUserSystem->fetch_assoc();
        $totalUserSystem = $row["total_usersystem"];
    } else {
        $totalUserSystem = 0;
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
    <link rel="stylesheet" type="text/css" href="../style/dasboard.css">
</head>
<body>
    <!-- Main Navbar -->
    <div class="main-navbar">
        <h2>Book Store Management System</h2>
        <div class="logout-btn" onclick="logout()">
            <span>Logout</span>
            <img src="../img/icons8-shutdown-64.png">
        </div>
    </div>

    <div class="wrapper">
    <!-- Side Navbar -->
        <div class="side-navbar">
            <div class="user-profile">
                <img src="../img/avatar 1.png" alt="Profile Picture" class="profile-picture">
                <br><span class="username"><?php echo $_SESSION['username']; ?></span>
            </div>
            <div class="nav-items">
                <?php
                if (isset($_SESSION['level'])) {
                    $role = $_SESSION['level'];

                    if ($role === 'admin') {
                    echo '
                        <div class="nav-items-list">                
                            <a href="#" class="nav-link">
                                <img src="../img/dasboard.png">
                                <span>Dasboard</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="#" class="nav-link">
                                <img src="../img/category.png">
                                <span>Category</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="#" class="nav-link">
                                <img src="../img/books.png">
                                <span>Books</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="#" class="nav-link">
                                <img src="../img/transaction.png">
                                <span>Transaction</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="#" class="nav-link">
                                <img src="../img/history.png">
                                <span>History</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="#" class="nav-link">
                                <img src="../img/usermanagement.png">
                                <span>User Management</span>
                            </a>
                        </div>
                    ';
                    }
                    elseif ($role === 'staff') {
                    echo '
                    <div class="nav-items-list">                
                        <a href="#" class="nav-link">
                            <img src="../img/dasboard.png">
                            <span>Dasboard</span>
                        </a>
                    </div>
                    <div class="nav-items-list">                
                        <a href="#" class="nav-link">
                            <img src="../img/category.png">
                            <span>Category</span>
                        </a>
                    </div>
                    <div class="nav-items-list">                
                        <a href="#" class="nav-link">
                            <img src="../img/books.png">
                            <span>Books</span>
                        </a>
                    </div>
                    ';
                    }
                    elseif ($role === 'cashier') {
                    echo '
                    <div class="nav-items-list">                
                        <a href="#" class="nav-link">
                            <img src="../img/dasboard.png">
                            <span>Dasboard</span>
                        </a>
                    </div>
                    <div class="nav-items-list">                
                        <a href="#" class="nav-link">
                            <img src="../img/transaction.png">
                            <span>Transaction</span>
                        </a>
                    </div>
                    <div class="nav-items-list">                
                        <a href="#" class="nav-link">
                            <img src="../img/history.png">
                            <span>History</span>
                        </a>
                    </div>
                    ';
                    }
                }
                ?>
            </div>
        </div>
        
        <div class="container">
            <div class="content-page-title">
                <span>Dasboard</span>
            </div>
            <div class="main-content">
                <div class="content ct-book">
                    <div class="img-icon">
                        <img src="../img/db-book.png">
                    </div>
                    <span class="desc-content">Total Book:</span><span class="value-content"><?php echo $totalBook; ?></span>
                </div>
                <div class="content ct-earn">
                    <div class="img-icon">
                        <img class="img-earn" src="../img/db-earnings.png">
                    </div>
                    <span class="desc-content">Earnings:</span><span class="value-content">$<?php echo $totalEarn; ?></span>
                </div>
                <div class="content ct-category">
                    <div class="img-icon">
                        <img src="../img/db-category.png">
                    </div>
                    <span class="desc-content">Categories:</span><span class="value-content"><?php echo $totalCategory; ?></span>
                </div>
            </div>

            <div class="main-content mc-2">
                <div class="content ct-stock">
                    <div class="img-icon">
                        <img class="img-stock" src="../img/db-stock.png">
                    </div>
                    <span class="desc-content">Stok:</span><span class="value-content"><?php echo $totalStock; ?></span>
                </div>
                <div class="content ct-transaction">
                    <div class="img-icon">
                        <img src="../img/db-transaction.png">
                    </div>
                    <span class="desc-content">Transaction:</span><span class="value-content"><?php echo $totalTransaction; ?></span>
                </div>
                <div class="content ct-systemuser">
                    <div class="img-icon">
                        <img src="../img/db-usermanagement.png">
                    </div>
                    <span class="desc-content">System Users:</span><span class="value-content"><?php echo $totalUserSystem; ?></span>
                </div>
            </div>
        </div>
    </div>

    <script src="../script/script.js"></script>

</body>
</html>

