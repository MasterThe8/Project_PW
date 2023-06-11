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
    <title>Book - BSMS</title>
    <link rel="stylesheet" type="text/css" href="../../style/book.css">
    <script src="../../script/script.js" defer></script>
    <script src="../../script/book.js" defer></script>
</head>
<body>
    <!-- ADD BOOK -->
    <div class="dialog-additem" id="addBookDialog">
        <div class="dialog-content-wrapper">
            <form method="POST" action="addBook.php" enctype="multipart/form-data">
            <h5>Add New Book</h5>
            <label for="bookCode">Book Code  :</label>
            <input type="text" id="bookCode" name="bookCodeAdd" required>
            <br>
            <label for="bookName">Book Title :</label>
            <input type="text" id="bookName" name="bookNameAdd" required>
            <br>
            <label for="bookYear">Year :</label>
            <input type="text" id="bookYear" name="bookYearAdd" required>
            <br>
            <label for="bookPrice">Price :</label>
            <input type="text" id="bookPrice" name="bookPriceAdd" required>
            <br>
            <label for="bookCategory">Category :</label>
            <select id="bookCategory" name="bookCategoryAdd" required>
                <?php
                $sql = "SELECT category_code, category_name FROM book_category";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $categoryCode = $row["category_code"];
                        $categoryName = $row["category_name"];
                        echo "<option value='$categoryCode'>$categoryName</option>";
                    }
                }
                ?>
            </select>
            <br>
            <label for="bookPublisher">Publisher :</label>
            <input type="text" id="bookPublisher" name="bookPublisherAdd" required>
            <br>
            <label for="bookWriter">Writer :</label>
            <input type="text" id="bookWriter" name="bookWriterAdd" required>
            <br>
            <label for="bookStock">Stock :</label>
            <input type="text" id="bookStock" name="bookStockAdd" required>
            <br>
            <label for="bookImg">Book Cover :</label>
            <input type="file" id="bookImg" name="bookImgAdd" accept="image/*">
            <br>
            <div class="dialog-btn">
                <button class="save-btn" type="submit">Save</button>
                <button class="close-btn" type="button" onclick="closeBook()">Close</button>
            </div>
            </form>
        </div>
    </div>
    <!-- EDIT BOOK -->
    <div class="dialog-additem" id="editBookDialog">
        <div class="dialog-content-wrapper">
            <form method="POST" action="editBook.php">
            <h5>Edit Book</h5>
            <label for="bookCode">Book Code  :</label>
            <input type="text" id="bookCodeEdit" name="bookCodeEdit" required>
            <br>
            <label for="bookName">Book Title :</label>
            <input type="text" id="bookNameEdit" name="bookNameEdit" required>
            <br>
            <label for="bookYear">Year :</label>
            <input type="text" id="bookYearEdit" name="bookYearEdit" required>
            <br>
            <label for="bookPrice">Price :</label>
            <input type="text" id="bookPriceEdit" name="bookPriceEdit" required>
            <br>
            <label for="bookCategory">Category :</label>
            <select id="bookCategoryEdit" name="bookCategoryEdit" required>
                <?php
                $sql = "SELECT category_code, category_name FROM book_category";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $categoryCode = $row["category_code"];
                        $categoryName = $row["category_name"];
                        echo "<option value='$categoryCode'>$categoryName</option>";
                    }
                }
                ?>
            </select>
            <br>
            <label for="bookPublisher">Publisher :</label>
            <input type="text" id="bookPublisherEdit" name="bookPublisherEdit" required>
            <br>
            <label for="bookWriter">Writer :</label>
            <input type="text" id="bookWriterEdit" name="bookWriterEdit" required>
            <br>
            <label for="bookStock">Stock :</label>
            <input type="text" id="bookStockEdit" name="bookStockEdit" required>
            <br>
            <label for="bookImg">Book Cover :</label>
            <input type="file" id="bookImg" name="bookImgEdit" accept="image/*">
            <br>
            <div class="dialog-btn">
                <button class="save-btn" type="submit">Save</button>
                <button class="close-btn" type="button" onclick="closeBook()">Close</button>
            </div>
            </form>
        </div>
    </div>
    <!-- DELETE BOOK -->
    <div class="dialog-additem" id="deleteBookDialog">
        <div class="dialog-content-wrapper">
            <form method="POST" action="deleteBook.php">
            <h5>Delete Book</h5>
            <label for="bookCode">Book Code  :</label>
            <input type="text" id="bookCodeDelete" name="bookCodeDelete" readonly>
            <br>
            <label for="bookName">Book Title :</label>
            <input type="text" id="bookNameDelete" name="bookNameDelete" readonly>
            <br>
            <label for="bookYear">Year :</label>
            <input type="text" id="bookYearDelete" name="bookYearDelete" readonly>
            <br>
            <label for="bookCategory">Category :</label>
            <input type="text" id="bookCategoryDelete" name="bookCategoryDelete" readonly>
            <br>
            <label for="bookPublisher">Publisher :</label>
            <input type="text" id="bookPublisherDelete" name="bookPublisherDelete" readonly>
            <br>
            <label for="bookWriter">Writer :</label>
            <input type="text" id="bookWriterDelete" name="bookWriterDelete" readonly>
            <br>
            <label for="bookStock">Stock :</label>
            <input type="text" id="bookStockDelete" name="bookStockDelete" readonly>
            <br>
            <div class="dialog-btn">
                <button class="save-btn" type="submit">Confirm</button>
                <button class="close-btn" type="button" onclick="closeBook()">Cancel</button>
            </div>
            </form>
        </div>
    </div>
    <div id="overlay"></div>
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
                        elseif ($role === 'staff') {
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
                        ';
                        }
                }
                ?>
            </div>
        </div>
        
        <div class="container">
            <div class="content-page-title">
                <span>Books</span>
            </div>
            <div class="main-content">
                <div class="content">
                    <div class="content-head">
                        <button onclick="addBook()">Add Category</button>
                    </div>
                    <div class="table-category">
                    <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Book Name</th>
                                    <th>Cover</th>
                                    <th>Year</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Publisher</th>
                                    <th>Author</th>
                                    <th>Stock</th>
                                    <th>Action</th>
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


                                        // $book = $row[""];
                                        $bookCode = $row["book_code"];
                                        $bookTitle = $row["book_title"];
                                        $bookImg = "img/" . $row["book_img"];
                                        // $bookImg = $row["book_img"];
                                        $bookYear = $row["year"];
                                        $bookPrice = $row["price"];
                                        $bookPublisher = $row["publisher"];
                                        $bookWriter = $row["writer"];
                                        $bookStock = $row["stock"];

                                        echo "<tr>";
                                        // echo "<td>" . $book . "</td>";
                                        echo "<td>" . $bookCode . "</td>";
                                        echo "<td>" . $bookTitle . "</td>";
                                        echo "<td><img class='book-cover' src='" . $bookImg . "'></td>";
                                        echo "<td>" . $bookYear . "</td>";
                                        echo "<td>" . $bookPrice . "</td>";
                                        echo "<td>" . $bookCategory . "</td>";
                                        echo "<td>" . $bookPublisher . "</td>";
                                        echo "<td>" . $bookWriter . "</td>";
                                        echo "<td>" . $bookStock . "</td>";
                                        echo "<td>";
                                        echo "<button class='edit-btn-table' onclick='editBook(\"$bookCode\", \"$bookTitle\", \"$bookYear\", \"$bookPrice\", \"$bookCategory\", \"$bookPublisher\", \"$bookWriter\", \"$bookStock\")'>Edit</button>";
                                        echo "<button class='delete-btn-table' onclick='deleteBook(\"$bookCode\", \"$bookTitle\", \"$bookYear\", \"$bookCategory\", \"$bookPublisher\", \"$bookWriter\", \"$bookStock\")'>Delete</button>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
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