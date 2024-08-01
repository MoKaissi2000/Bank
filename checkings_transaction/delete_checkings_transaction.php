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

    // Prepare statement to delete transaction
    $sql = "DELETE FROM checking_transactions WHERE transid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transid);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Transaction deleted successfully.";
    } else {
        echo "Error deleting transaction: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
