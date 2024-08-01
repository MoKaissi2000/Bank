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
    $transid = $_POST['transid'];

    $sql = "SELECT * FROM investment_transactions WHERE transid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo "Transaction ID: " . $row["transid"] . " - Type: " . $row["trans_type"] .
             " - Date: " . $row["trans_date"] . " - Amount: " . $row["trans_amount"] .
             " - Last Name: " . $row["lastname"] . " - First Name: " . $row["firstname"] .
             " - Phone: " . $row["phone"] . "<br>";
    } else {
        echo "Transaction not found.";
    }

    $stmt->close();
}
$conn->close();
?>
