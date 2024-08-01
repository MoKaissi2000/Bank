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

    // Get details including transid for transaction log
    $detailsSql = "SELECT firstname, lastname, phone, TransID FROM Investment WHERE Acct_no = ?";
    $detailsStmt = $conn->prepare($detailsSql);
    $detailsStmt->bind_param("i", $acct_no);
    $detailsStmt->execute();
    $detailsResult = $detailsStmt->get_result();
    $row = $detailsResult->fetch_assoc();

    // Check if account details were found
    if ($row) {
        // Update the balance
        $updateSql = "UPDATE Investment SET Balance = Balance + ? WHERE Acct_no = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("di", $amount, $acct_no);
        $updateStmt->execute();

        // Log the deposit transaction using the existing TransID
        $transid = $row['TransID'];  // Retrieved TransID from Investments
        $trans_type = 'deposit';
        $trans_date = date('Y-m-d');
        $sql_trans = "INSERT INTO investment_transactions (transid, trans_type, trans_date, trans_amount, lastname, firstname, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_trans = $conn->prepare($sql_trans);
        $stmt_trans->bind_param("issdsss", $transid, $trans_type, $trans_date, $amount, $row['lastname'], $row['firstname'], $row['phone']);
        $stmt_trans->execute();

        if ($updateStmt->affected_rows > 0 && $stmt_trans->affected_rows > 0) {
            echo "Deposit successful.";
        } else {
            echo "Error: " . $updateStmt->error . " " . $stmt_trans->error;
        }

        $updateStmt->close();
        $stmt_trans->close();
    } else {
        echo "No account found with that account number.";
    }

    $detailsStmt->close();
}
$conn->close();
?>
