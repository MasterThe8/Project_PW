<?php
session_start();

require_once '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the book code from the POST data
    $code = $_POST['code'];

    // Update the stock value in the database
    $sql = "UPDATE books SET stock = stock - 1 WHERE code = :code";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':code', $code);
    $stmt->execute();

    // You can perform additional checks and error handling as needed

    // Return a response indicating success
    echo "Stock updated successfully";
}
?>
