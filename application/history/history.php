<?php
session_start();

require_once '../../connection.php';

    // $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1366">
    <title>History - BSMS</title>
    <link rel="stylesheet" type="text/css" href="../../style/book.css">
    <script src="../../script/script.js" defer></script>
    <script src="../../script/book.js" defer></script>
</head>
<body>
    <!-- Main Navbar -->
    <div class="main-navbar">
        <h2>Book Store Management System</h2>
        <div class="logout-btn" onclick="logout()">
            <span>Logout</span>
            <img src="../../img/icons8-shutdown-64.png">
        </div>
    </div>

    <div class="wrapper">
    <!-- Side Navbar -->
        <div class="side-navbar">
            <div class="user-profile">
                <img src="../../img/avatar 1.png" alt="Profile Picture" class="profile-picture">
                <div class="user-info">
                    <span class="username"><?php echo $_SESSION['fullname']; ?></span>
                    <br>
                    <span class="role"><?php echo $_SESSION['level']; ?></span>
                </div>
            </div>
            <div class="nav-items">
            <div class="nav-items">
                <?php
                if (isset($_SESSION['level'])) {
                    $role = $_SESSION['level'];

                    if ($role === 'admin') {
                    echo '
                        <div class="nav-items-list">                
                            <a href="dashboard.php" class="nav-link">
                                <img src="../img/dashboard.png">
                                <span>Dashboard</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="category/category.php" class="nav-link">
                                <img src="../img/category.png">
                                <span>Category</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="book/book.php" class="nav-link">
                                <img src="../img/books.png">
                                <span>Books</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="transaction/transaction.php" class="nav-link">
                                <img src="../img/transaction.png">
                                <span>Transaction</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="history/history.php" class="nav-link">
                                <img src="../img/history.png">
                                <span>History</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="user/user.php" class="nav-link">
                                <img src="../img/usermanagement.png">
                                <span>User Management</span>
                            </a>
                        </div>
                    ';
                    }
                    elseif ($role === 'cashier') {
                    echo '
                    <div class="nav-items-list">                
                        <a href="dashboard.php" class="nav-link">
                            <img src="../img/dashboard.png">
                            <span>Dashboard</span>
                        </a>
                    </div>
                    <div class="nav-items-list">                
                        <a href="transaction/transaction.php" class="nav-link">
                            <img src="../img/transaction.png">
                            <span>Transaction</span>
                        </a>
                    </div>
                    <div class="nav-items-list">                
                        <a href="history/history.php" class="nav-link">
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
                <span>Transaction History</span>
            </div>
            <div class="main-content">
                <div class="content">
                    <div class="table-category">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Book</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                    <th>Cashier</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM transaction";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $transactionCode = $row["transaction_code"];
                                        $customerName = $row["buyer_name"];
                                        $date = $row["tgl"];
                                        $book = $row["bookname"];
                                        $qty = $row["book_qty"];
                                        $amount = $row["total"];
                                        
                                        $userCode = $row["user_code"];
                                        $sqlUser = "SELECT fullname FROM user WHERE user_code = '$userCode'";
                                        $resultUser = $conn->query($sqlUser);
                                        $cashier = "";
                                        if ($resultUser->num_rows > 0) {
                                            $cashier = $resultUser->fetch_assoc()["fullname"];
                                        }
                        
                                        echo "<tr>";
                                        echo "<td>$transactionCode</td>";
                                        echo "<td>$customerName</td>";
                                        echo "<td>$date</td>";
                                        echo "<td>$book</td>";
                                        echo "<td>$qty</td>";
                                        echo "<td>$amount</td>";
                                        echo "<td>$cashier</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No transactions found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>


<?php
    $conn->close();
?>