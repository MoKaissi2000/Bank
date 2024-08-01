<?php
$servername = "localhost";
$username = "quickme1_4211";
$password = "csci4211";
$dbname = "dbvpny1qngaxgp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch all transactions
$sql = "SELECT * FROM savings_transactions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Transaction ID: " . $row["transid"]. " - Transaction Type: " . $row["trans_type"]. " - Date: " . $row["trans_date"]. " - Amount: " . $row["trans_amount"] . "<br>";
    }
} else {
    echo "No transactions found";
}

$conn->close();
?>
