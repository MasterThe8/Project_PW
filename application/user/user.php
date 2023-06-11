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
    <title>System Users - BSMS</title>
    <link rel="stylesheet" type="text/css" href="../../style/user.css">
    <script src="../../script/script.js" defer></script>
    <script src="../../script/user.js" defer></script>
</head>
<body>
    <!-- ADD USER -->
    <div class="dialog-additem" id="addUserDialog">
        <div class="dialog-content-wrapper">
            <form method="POST" action="addUser.php">
            <h5>Add New User</h5>
            <label for="UserFullname">Fullname:</label>
            <input type="text" id="UserFullname" name="UserFullnameAdd" required>
            <br>
            <label for="Username">Username :</label>
            <input type="text" id="Username" name="UsernameAdd" required>
            <br>
            <label for="UserPassword">Password :</label>
            <input type="text" id="UserPassword" name="UserPasswordAdd" required>
            <br>
            <label for="UserLevel">Level :</label>
            <select id="UserLevel" name="UserLevelAdd" required>
                <option class="default-select" selected="" disabled="" hidden="">User Role</option>
                <option>admin</option>
                <option>cashier</option>
                <option>staff</option>
            </select>
            <div class="dialog-btn">
                <button class="save-btn" type="submit">Add Users</button>
                <button class="close-btn" type="button" onclick="closeUser()">Close</button>
            </div>
            </form>
        </div>
    </div>
    <!-- EDIT USER -->
    <div class="dialog-additem" id="editUserDialog">
        <div class="dialog-content-wrapper">
            <form method="POST" action="editUser.php">
            <h5>Edit User</h5>
            <label for="UserCode">User Code <i>(Permanent)</i>:</label>
            <input type="text" id="userCodeEdit" name="userCodeEdit" readonly>
            <br>
            <label for="UserFullname">Fullname :</label>
            <input type="text" id="userFullnameEdit" name="userFullnameEdit" required>
            <br>
            <label for="Username">Username :</label>
            <input type="text" id="usernameEdit" name="usernameEdit" required>
            <br>
            <label for="UserPassword">New Password :</label>
            <input type="text" id="userPassword" name="userPasswordEdit" required>
            <br>
            <label for="UserLevel">Level :</label>
            <select id="userLevel" name="userLevelEdit" required>
                <option>admin</option>
                <option>cashier</option>
                <option>staff</option>
            </select>
            <div class="dialog-btn">
                <button class="save-btn" type="submit">Save</button>
                <button class="close-btn" type="button" onclick="closeUser()">Close</button>
            </div>
            </form>
        </div>
    </div>
    <!-- DELETE USER -->
    <div class="dialog-additem" id="deleteUserDialog">
        <div class="dialog-content-wrapper">
            <form method="POST" action="deleteUser.php">
            <h5>Delete User</h5>
            <label for="UserCode">User Code :</label>
            <input type="text" id="userCodeDelete" name="userCodeDelete" readonly>
            <br>
            <label for="UserFullname">Fullname :</label>
            <input type="text" id="userFullnameDelete" name="userFullnameDelete" readonly>
            <br>
            <label for="Username">Username :</label>
            <input type="text" id="usernameDelete" name="usernameDelete" readonly>
            <br>
            <label for="UserLevel">Level :</label>
            <select id="userLevel" name="userLevelEdit" readonly>
                <option>admin</option>
                <option>cashier</option>
                <option>staff</option>
            </select>
            <div class="dialog-btn">
                <button class="save-btn" type="submit">Delete</button>
                <button class="close-btn" type="button" onclick="closeUser()">Close</button>
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
                }
                ?>
            </div>
        </div>
        
        <div class="container">
            <div class="content-page-title">
                <span>System Users</span>
            </div>
            <div class="main-content">
                <div class="content">
                    <div class="content-head">
                        <button onclick="addUser()">Add New Users</button>
                    </div>
                    <div class="table-category">
                    <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fullname</th>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM user";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {

                                        // $user = $row[""];
                                        $userCode = $row["user_code"];
                                        $userFull = $row["fullname"];
                                        $username = $row["username"];
                                        $userLvl = $row["level"];

                                        echo "<tr>";
                                        // echo "<td>" . $user . "</td>";
                                        echo "<td>" . $userCode . "</td>";
                                        echo "<td>" . $userFull . "</td>";
                                        echo "<td>" . $username . "</td>";
                                        echo "<td>" . $userLvl . "</td>";
                                        echo "<td>";
                                        echo "<button class='edit-btn-table' onclick='editUser(\"$userCode\" ,\"$userFull\", \"$username\", \"$userLvl\")'>Edit</button>";
                                        echo "<button class='delete-btn-table' onclick='deleteUser(\"$userCode\" ,\"$userFull\", \"$username\", \"$userLvl\")'>Delete</button>";
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