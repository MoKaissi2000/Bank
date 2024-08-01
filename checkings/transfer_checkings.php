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
    // Check if required keys exist in $_POST array
    if (isset($_POST['sender_acct_no'], $_POST['receiver_acct_no'], $_POST['amount'])) {
        $sender_acct_no = $_POST['sender_acct_no'];
        $receiver_acct_no = $_POST['receiver_acct_no'];
        $amount = $_POST['amount'];

        // Start transaction
        $conn->begin_transaction();

        // Update sender's balance
        $sql_sender = "UPDATE checking SET Balance = Balance - ? WHERE Acct_no = ?";
        $stmt_sender = $conn->prepare($sql_sender);
        $stmt_sender->bind_param("di", $amount, $sender_acct_no);
        $stmt_sender->execute();

        // Update receiver's balance
        $sql_receiver = "UPDATE checking SET Balance = Balance + ? WHERE Acct_no = ?";
        $stmt_receiver = $conn->prepare($sql_receiver);
        $stmt_receiver->bind_param("di", $amount, $receiver_acct_no);
        $stmt_receiver->execute();

        if ($stmt_sender->affected_rows > 0 && $stmt_receiver->affected_rows > 0) {
            // Transfer successful
            // Log the transfer for sender and receiver
            $trans_type = 'Transfer';
            $trans_date = date('Y-m-d H:i:s'); // Current timestamp

            // Log the transfer for sender
            $sql_trans_sender = "INSERT INTO checking_transactions (trans_type, trans_date, trans_amount, lastname, firstname, phone) SELECT ?, ?, ?, lastname, firstname, phone FROM checking WHERE Acct_no = ?";
            $stmt_trans_sender = $conn->prepare($sql_trans_sender);
            $stmt_trans_sender->bind_param("ssdi", $trans_type, $trans_date, $amount, $sender_acct_no);
            $stmt_trans_sender->execute();

            // Log the transfer for receiver
            $sql_trans_receiver = "INSERT INTO checking_transactions (trans_type, trans_date, trans_amount, lastname, firstname, phone) SELECT ?, ?, ?, lastname, firstname, phone FROM checking WHERE Acct_no = ?";
            $stmt_trans_receiver = $conn->prepare($sql_trans_receiver);
            $stmt_trans_receiver->bind_param("ssdi", $trans_type, $trans_date, $amount, $receiver_acct_no);
            $stmt_trans_receiver->execute();

            if ($stmt_trans_sender->affected_rows > 0 && $stmt_trans_receiver->affected_rows > 0) {
                $conn->commit();
                echo "Transfer successful and recorded.";
            } else {
                $conn->rollback();
                echo "Failed to record transfer.";
            }
        } else {
            // Rollback if either update fails
            $conn->rollback();
            echo "Transfer failed: " . $stmt_sender->error . " " . $stmt_receiver->error;
        }

        $stmt_sender->close();
        $stmt_receiver->close();
        $stmt_trans_sender->close();
        $stmt_trans_receiver->close();
    } else {
        // Handle missing keys in $_POST array
        echo "One or more required fields are missing.";
    }
}

$conn->close();
?>
