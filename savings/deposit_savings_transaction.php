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

    // Update the balance in the Savings table
    $sql = "UPDATE savings SET Balance = Balance + ? WHERE Acct_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $amount, $acct_no);
    $stmt->execute();

    // Fetch customer details from the Savings table
    $sql_customer = "SELECT transid, lastname, firstname, phone FROM savings WHERE Acct_no = ?";
    $stmt_customer = $conn->prepare($sql_customer);
    $stmt_customer->bind_param("i", $acct_no);
    $stmt_customer->execute();
    $stmt_customer->bind_result($transid, $lastname, $firstname, $phone);
    $stmt_customer->fetch();
    $stmt_customer->close();

    // Log the transaction with the existing transaction ID
    $trans_type = 'Deposit';
    $trans_date = date('Y-m-d H:i:s'); // Current timestamp

    $sql_trans = "INSERT INTO savings_transactions (transid, trans_type, trans_date, trans_amount, lastname, firstname, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_trans = $conn->prepare($sql_trans);
    $stmt_trans->bind_param("ssdssss", $transid, $trans_type, $trans_date, $amount, $lastname, $firstname, $phone);
    $stmt_trans->execute();

    if ($stmt->affected_rows > 0 && $stmt_trans->affected_rows > 0) {
        $conn->commit();
        echo "Deposit successful and recorded.";
    } else {
        $conn->rollback();
        echo "Failed to record deposit.";
    }

    $stmt->close();
    $stmt_trans->close();
}

$conn->close();
?>
