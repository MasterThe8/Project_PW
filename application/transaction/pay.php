<?php
session_start();

require_once '../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cashierName = $_POST['cashierName'];
    $customerName = $_POST['customerName'];
    $cartData = $_POST['cartData'];

    $cartItems = json_decode($cartData, true);

    $sqlCount = "SELECT COUNT(*) AS count FROM transaction";
    $resultCount = $conn->query($sqlCount);
    $count = $resultCount->fetch_assoc()['count'];
    $transactionCode = $count + 1;

    $sqlUser = "SELECT user_code FROM user WHERE fullname = '$cashierName'";
    $resultUser = $conn->query($sqlUser);
    $userCode = $resultUser->fetch_assoc()['user_code'];

    $currentDate = date('Y-m-d');

    $conn->autocommit(FALSE); // Memulai transaksi

    // Memasukkan data ke tabel "transaction"
    $sqlInsertTransaction = "INSERT INTO transaction (transaction_code, user_code, buyer_name, total, tgl, bookname, book_qty)
                             VALUES ('$transactionCode', '$userCode', '$customerName', 0, '$currentDate', '', 0)";

    if ($conn->query($sqlInsertTransaction) === TRUE) {
        $total = 0;
        foreach ($cartItems as $item) {
            $bookCode = $item['code'];
            $bookTitle = $item['title'];
            $bookQty = $item['stock'];
            $subtotal = $item['subtotal'];

            // Periksa apakah stok mencukupi
            $sqlCheckStock = "SELECT stock FROM book WHERE book_code = '$bookCode'";
            $resultStock = $conn->query($sqlCheckStock);
            $currentStock = $resultStock->fetch_assoc()['stock'];

            if ($currentStock < $bookQty) {
                $conn->rollback(); // Membatalkan transaksi jika stok tidak mencukupi
                echo '<script>alert("Stok buku tidak mencukupi!"); window.location.href = "transaction.php";</script>';
                exit;
            }

            $sqlInsertTransactionDetail = "INSERT INTO transaction_detail (transaction_code, book_code, amount)
                                           VALUES ('$transactionCode', '$bookCode', '$bookQty')";

            if ($conn->query($sqlInsertTransactionDetail) === FALSE) {
                $conn->rollback(); // Membatalkan transaksi jika terjadi kesalahan
                echo '<script>alert("Terjadi kesalahan, periksa kembali inputan Anda!"); window.location.href = "transaction.php";</script>';
                exit;
            }

            $total += $subtotal;

            // Update nilai stok pada tabel "book"
            $newStock = $currentStock - $bookQty;
            $sqlUpdateStock = "UPDATE book SET stock = '$newStock' WHERE book_code = '$bookCode'";
            if ($conn->query($sqlUpdateStock) === FALSE) {
                $conn->rollback(); // Membatalkan transaksi jika terjadi kesalahan
                echo '<script>alert("Terjadi kesalahan, periksa kembali inputan Anda!"); window.location.href = "transaction.php";</script>';
                exit;
            }
        }

        // Mengupdate total pada tabel "transaction" berdasarkan total yang dihitung
        $sqlUpdateTotal = "UPDATE transaction SET total = '$total', bookname = '$bookTitle', book_qty = '$bookQty' WHERE transaction_code = '$transactionCode'";
        if ($conn->query($sqlUpdateTotal) === FALSE) {
            $conn->rollback(); // Membatalkan transaksi jika terjadi kesalahan
            echo '<script>alert("Terjadi kesalahan, periksa kembali inputan Anda!"); window.location.href = "transaction.php";</script>';
            exit;
        }

        $conn->commit(); // Menyimpan transaksi
        // Tambahkan code untuk melakukan print struk setelah transaksi berhasil
        $transaction = new stdClass();
        $transaction->transaction_code = $transactionCode;
        $transaction->fullname = $cashierName;
        $transaction->buyer_name = $customerName;
        $transaction->tgl = $currentDate;
        $transaction->total = $subtotal;
        
        // Print struk
        echo '<h2>Transaction Note</h2>';
        echo 'Transaction No. : ' . $transaction->transaction_code . '<br>';
        echo 'Cashier : ' . $transaction->fullname . '<br>';
        echo 'Customer : ' . $transaction->buyer_name . '<br>';
        echo 'Date : ' . $transaction->tgl . '<br>';

        echo '<table border="1" style="border-collapse: collapse;">';
        echo '<tr>';
        echo '<th>No</th>';
        echo '<th>Book Title</th>';
        echo '<th>Price</th>';
        echo '<th>Amount</th>';
        echo '<th>Subtotal</th>';
        echo '</tr>';
        
        $no = 0;
        foreach ($cartItems as $book) {
            $no++;
            $bookTitle = $book['title'];
            $price = $book['price'];
            $amount = $book['stock'];
            $subtotal = $book['subtotal'];

            echo '<tr>';
            echo '<td>' . $no . '</td>';
            echo '<td>' . $bookTitle . '</td>';
            echo '<td>' . number_format($price) . '</td>';
            echo '<td>' . $amount . '</td>';
            echo '<td>' . number_format($subtotal) . '</td>';
            echo '</tr>';
        }

        echo '<tr>';
        echo '<th colspan="4">Total</th>';
        echo '<td>' . number_format($transaction->total) . '</td>';
        echo '</tr>';

        echo '</table>';

        echo '<script type="text/javascript">';
        echo 'window.print();';
        echo 'setTimeout(() => {';
        echo 'location.href = "transaction.php";';
        echo '}, 2500);';
        echo '</script>';
    } else {
        echo '<script>alert("Terjadi kesalahan, periksa kembali inputan Anda!"); window.location.href = "transaction.php";</script>';
    }

    $conn->close();
}
?>
