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
    <title>Category - BSMS</title>
    <link rel="stylesheet" type="text/css" href="../../style/category.css">
    <script src="../../script/script.js" defer></script>
    <script src="../../script/category.js" defer></script>
</head>

<body>
    <!-- ADD CATEGORY -->
    <div class="dialog-additem" id="addCategoryDialog">
        <form method="POST" action="addCategory.php">
        <h5>Add New Category</h5>
        <label for="categoryCode">Category Code  :</label>
        <input type="text" id="categoryCode" name="categoryCodeAdd" required>
        <br>
        <label for="categoryName">Category Name :</label>
        <input type="text" id="categoryName" name="categoryNameAdd" required>
        <br>
        <div class="dialog-btn">
            <button class="save-btn" type="submit">Save</button>
            <button class="close-btn" type="button" onclick="closeCategory()">Close</button>
        </div>
        </form>
    </div>
    <!-- EDIT CATEGORY -->
    <div class="dialog-additem" id="editCategoryDialog">
        <form method="POST" action="editCategory.php">
        <h5>Edit Category</h5>
        <label for="categoryCodeLabel">Category Code  :</label>
        <input type="text" id="categoryCodeEdit" name="categoryCodeEdit" required>
        <br>
        <label for="categoryName">Category Name :</label>
        <input type="text" id="categoryNameEdit" name="categoryNameEdit" required>
        <br>
        <div class="dialog-btn">
            <button class="save-btn" type="submit">Save</button>
            <button class="close-btn" type="button" onclick="closeCategory()">Close</button>
        </div>
        </form>
    </div>
    <!-- DELETE CATEGORY -->
    <div class="dialog-additem" id="deleteCategoryDialog">
        <form method="POST" action="deleteCategory.php">
        <h5>Delete Category</h5>
        <label for="categoryCodeLabel">Category Code  :</label>
        <input type="text" id="categoryCodeDelete" name="categoryCodeDelete" readonly>
        <br>
        <label for="categoryName">Category Name :</label>
        <input type="text" id="categoryNameDelete" name="categoryNameDelete" readonly>
        <br>
        <div class="dialog-btn">
            <button class="save-btn" type="submit">Delete</button>
            <button class="close-btn" type="button" onclick="closeCategory()">Cancel</button>
        </div>
        </form>
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
                            <a href="#" class="nav-link">
                                <img src="../../img/books.png">
                                <span>Books</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="#" class="nav-link">
                                <img src="../../img/transaction.png">
                                <span>Transaction</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="#" class="nav-link">
                                <img src="../../img/history.png">
                                <span>History</span>
                            </a>
                        </div>
                        <div class="nav-items-list">                
                            <a href="#" class="nav-link">
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
                        <a href="#" class="nav-link">
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
                <span>Dasboard</span>
            </div>
            <div class="main-content">
                <div class="content">
                    <div class="content-head">
                        <button onclick="addCategory()">Add Category</button>
                    </div>
                    <div class="table-category">
                        <table>
                            <thead>
                                <tr>
                                    <!-- <th>No.</th> -->
                                    <th>Category Code</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Query untuk mengambil data dari tabel book_category
                                    $sql = "SELECT * FROM book_category";
                                    $result = $conn->query($sql);

                                    // Nomor urut
                                    $no = 1;

                                    // Loop untuk menampilkan data pada tabel
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $categoryCode = $row["category_code"];
                                            $categoryName = $row["category_name"];

                                            echo "<tr>";
                                            echo "<td>" . $categoryCode . "</td>";
                                            echo "<td>" . $categoryName . "</td>";
                                            echo "<td>";
                                            echo "<button class='edit-btn-table' onclick='editCategory(\"$categoryCode\", \"$categoryName\")'>Edit</button>";
                                            echo "<button class='delete-btn-table' onclick='deleteCategory(\"$categoryCode\", \"$categoryName\")'>Delete</button>";
                                            echo "</td>";
                                            echo "</tr>";

                                            // $no++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No records found</td></tr>";
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