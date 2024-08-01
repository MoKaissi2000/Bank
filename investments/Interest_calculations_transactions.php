<?php
$servername = "localhost";
$username = "quickme1_4211";
$password = "csci4211";
$dbname = "dbvpny1qngaxgp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Get current date
$currentDate = date('Y-m-d');

// Check if it's the first day of the month
if (date('j', strtotime($currentDate)) == 1) {
    // Query to fetch investment accounts and their respective interest rates
    $sql = "SELECT Acct_no, interest_rate, Balance FROM Investment";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $acctNo = $row['Acct_no'];
            $interestRate = $row['interest_rate'];
            $currentBalance = $row['Balance'];

            // Calculate interest
            $interestAmount = $currentBalance * ($interestRate / 100);

            // Update balance with interest
            $newBalance = $currentBalance + $interestAmount;

            // Update investment account with new balance
            $updateSql = "UPDATE Investment SET Balance = ? WHERE Acct_no = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("di", $newBalance, $acctNo);
            $stmt->execute();
            $stmt->close();

            // Log interest transaction
            $logSql = "INSERT INTO investment_transactions (trans_type, trans_date, trans_amount, acct_no) VALUES (?, ?, ?, ?)";
            $transType = 'Interest';
            $transDate = $currentDate;
            $transAmount = $interestAmount;

            $stmtLog = $conn->prepare($logSql);
            $stmtLog->bind_param("ssdi", $transType, $transDate, $transAmount, $acctNo);
            $stmtLog->execute();
            $stmtLog->close();
        }

        echo "Interest calculated and applied successfully.";
    } else {
        echo "No investment accounts found.";
    }
} else {
    echo "Today is not the first day of the month. Interest calculation is not required.";
}

$conn->close();
?>