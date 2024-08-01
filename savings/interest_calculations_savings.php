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
if (date('j', strtotime($currentDate)) === '1') {
    // Query to fetch savings accounts and their respective interest rates
    $sql = "SELECT Acct_no, interest_rate, Balance FROM savings";
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

            // Update savings account with new balance
            $updateSql = "UPDATE savings SET Balance = ? WHERE Acct_no = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("di", $newBalance, $acctNo);
            $stmt->execute();
            $stmt->close();

            // Log interest transaction
            $logSql = "INSERT INTO savings_transactions (trans_type, trans_date, trans_amount, lastname, firstname, phone) VALUES (?, ?, ?, ?, ?, ?)";
            $transType = 'Interest';
            $transDate = $currentDate;
            $transAmount = $interestAmount;
            $lastname = ''; // Fill this with appropriate data if available
            $firstname = ''; // Fill this with appropriate data if available
            $phone = ''; // Fill this with appropriate data if available

            $stmtLog = $conn->prepare($logSql);
            $stmtLog->bind_param("ssdsss", $transType, $transDate, $transAmount, $lastname, $firstname, $phone);
            $stmtLog->execute();
            $stmtLog->close();
        }

        echo "Interest calculated and applied successfully.";
    } else {
        echo "No savings accounts found.";
    }
} else {
    echo "Today is not the first day of the month. Interest calculation is not required.";
}

$conn->close();
?>
