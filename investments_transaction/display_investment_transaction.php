<?php
$servername = "localhost";
$username = "quickme1_4211";
$password = "csci4211";
$dbname = "dbvpny1qngaxgp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM investment_transactions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "TransID: " . $row["transid"] . " - Type: " . $row["trans_type"] .
             " - Date: " . $row["trans_date"] . " - Amount: $" . $row["trans_amount"] .
             " - Last Name: " . $row["lastname"] . " - First Name: " . $row["firstname"] .
             " - Phone: " . $row["phone"] . "<br>";
    }
} else {
    echo "No transactions found.";
}
$conn->close();
?>
