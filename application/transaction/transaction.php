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
    <title>Transaction - BSMS</title>
    <link rel="stylesheet" type="text/css" href="../../style/transaction.css">
    <script src="../../script/script.js" defer></script>
    <script src="../../script/transaction.js" defer></script>
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
            <?php
                if (isset($_SESSION['level'])) {
                    $role = $_SESSION['level'];

                    if ($role === 'admin') {
                        echo '
                            <div class="nav-items-list">                
                                <a href="../dashboard.php" class="nav-link">
                                    <img src="../../img/dashboard.png">
                                    <span>Dashboard</span>
                                </a>
                            </div>
                            <div class="nav-items-list">                
                                <a href="../category/category.php" class="nav-link">
                                    <img src="../../img/category.png">
                                    <span>Category</span>
                                </a>
                            </div>
                            <div class="nav-items-list">                
                                <a href="../book/book.php" class="nav-link">
                                    <img src="../../img/books.png">
                                    <span>Books</span>
                                </a>
                            </div>
                            <div class="nav-items-list">                
                                <a href="../transaction/transaction.php" class="nav-link">
                                    <img src="../../img/transaction.png">
                                    <span>Transaction</span>
                                </a>
                            </div>
                            <div class="nav-items-list">                
                                <a href="../history/history.php" class="nav-link">
                                    <img src="../../img/history.png">
                                    <span>History</span>
                                </a>
                            </div>
                            <div class="nav-items-list">                
                                <a href="../user/user.php" class="nav-link">
                                    <img src="../../img/usermanagement.png">
                                    <span>User Management</span>
                                </a>
                            </div>
                        ';
                        }
                        elseif ($role === 'cashier') {
                            echo '
                                <div class="nav-items-list">                
                                    <a href="../dashboard.php" class="nav-link">
                                        <img src="../../img/dashboard.png">
                                        <span>Dashboard</span>
                                    </a>
                                </div>
                                <div class="nav-items-list">                
                                    <a href="../transaction/transaction.php" class="nav-link">
                                        <img src="../../img/transaction.png">
                                        <span>Transaction</span>
                                    </a>
                                </div>
                                <div class="nav-items-list">                
                                    <a href="../history/history.php" class="nav-link">
                                        <img src="../../img/history.png">
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
                <span>Transaction</span>
            </div>
            <div class="main-content">
                <div class="content">
                    <div class="content-head">
                        <h5 class="content-text">List of Book:</h5>
                    </div>
                    <div class="table-category">
                    <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Book Title</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql = "SELECT * FROM book";

                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $bookCategoryCode = $row["category_code"];

                                        // Query untuk mengambil nilai category_name berdasarkan category_code
                                        $categoryQuery = "SELECT category_name FROM book_category WHERE category_code = '$bookCategoryCode'";
                                        $categoryResult = $conn->query($categoryQuery);
                                
                                        if ($categoryResult->num_rows > 0) {
                                            $categoryRow = $categoryResult->fetch_assoc();
                                            $bookCategory = $categoryRow["category_name"];
                                        } else {
                                            $bookCategory = "Unknown"; // Jika tidak ada data kategori yang cocok
                                        }

                                        $bookCode = $row["book_code"];
                                        $bookTitle = $row["book_title"];
                                        $bookPrice = $row["price"];
                                        $bookStock = $row["stock"];
                                        
                                        echo "<tr>";
                                        echo "<td>" . $bookCode . "</td>";
                                        echo "<td>" . $bookTitle . "</td>";
                                        echo "<td>" . $bookCategory . "</td>";
                                        echo "<td>" . $bookPrice . "</td>";
                                        echo "<td id='stock_$bookCode' data-initial-stock='$bookStock'>" . $bookStock . "</td>";
                                        echo "<td>";
                                        echo "<button class='edit-btn-table' onclick='addToCart(\"$bookCode\", \"$bookTitle\", \"$bookPrice\");'>🛒</button>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <form method="POST" action="pay.php"> -->
                    <div class="content">
                        <div class="content-head">
                            <h5 class="content-text">Cart</h5>
                        </div>
                        <form method="POST" action="pay.php">
                        <div class="cashier-customer">
                            <label for="cashierName">Cashier :</label><br>
                            <select id="cashierName" name="cashierName" required>
                                <?php
                                $sql = "SELECT fullname FROM user";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $fullname = $row["fullname"];
                                        echo "<option>$fullname</option>";
                                    }
                                }
                                ?>
                            </select>
                            <br>
                            <label for="customerName">Customer Name :</label><br>
                            <input type="text" id="customerName" name="customerName" required>
                            <br>
                        </div>
                        <div class="table-cart">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="background-color: #006da0;">#</th>
                                        <th style="background-color: #006da0;">Title</th>
                                        <th style="background-color: #006da0;">Qty</th>
                                        <th style="background-color: #006da0;">Price</th>
                                        <th style="background-color: #006da0;">Subtotal</th>
                                        <th style="background-color: #006da0;">Act</th>
                                    </tr>
                                </thead>
                                <tbody id="cartTable">
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" id="cashierNameHidden" name="cashierName" value="">
                        <input type="hidden" id="customerNameHidden" name="customerName" value="">
                        <input type="hidden" id="cartDataHidden" name="cartData" value="">
                        <div class="payment-btn">
                        <button class="pay-btn" type="submit" onclick="prepareFormData()">Pay</button>
                            <button class="cancel-btn" type="button" onclick="clearCart()">Clear Cart</button>
                        </div>
                            </form>
                    </div>
                <!-- </form> -->
            </div>
        </div>
    </div>

</body>
</html>


<?php
    $conn->close();
?>