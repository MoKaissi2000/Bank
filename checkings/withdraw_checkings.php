<?php
$servername = "localhost";
$username = "quickme1_4211";
$password = "csci4211";
$dbname = "dbvpny1qngaxgp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acct_no = $_POST['acct_no'];
    $amount = $_POST['amount'];

    // Start transaction
    $conn->begin_transaction();

    // Update the balance in the Checkings table
    $sql = "UPDATE checking SET Balance = Balance - ? WHERE Acct_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $amount, $acct_no);
    $stmt->execute();

    // Retrieve customer details
    if ($stmt->affected_rows > 0) {
        $sql_info = "SELECT lastname, firstname, phone, transid FROM checking WHERE Acct_no = ?";
        $stmt_info = $conn->prepare($sql_info);
        $stmt_info->bind_param("i", $acct_no);
        $stmt_info->execute();
        $stmt_info->bind_result($lastname, $firstname, $phone, $transid);
        $stmt_info->fetch();
        $stmt_info->close();

        // Log the transaction
        $trans_type = 'Withdrawal';
        $trans_date = date('Y-m-d H:i:s'); // Current timestamp
        $sql_trans = "INSERT INTO checking_transactions (transid, trans_type, trans_date, trans_amount, lastname, firstname, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_trans = $conn->prepare($sql_trans);
        $stmt_trans->bind_param("ssdssss", $transid, $trans_type, $trans_date, $amount, $lastname, $firstname, $phone);
        $stmt_trans->execute();

        if ($stmt_trans->affected_rows > 0) {
            $conn->commit();
            echo "Withdrawal successful and recorded.";
        } else {
            $conn->rollback();
            echo "Withdrawal failed to record.";
        }
        $stmt_trans->close();
    } else {
        echo "Withdrawal failed: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
