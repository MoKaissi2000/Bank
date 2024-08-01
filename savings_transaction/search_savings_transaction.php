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

    // Prepare statement to search for transaction by ID
    $sql = "SELECT * FROM savings_transactions WHERE transid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "Transaction ID: " . $row["transid"]. " - Transaction Type: " . $row["trans_type"]. " - Date: " . $row["trans_date"]. " - Amount: " . $row["trans_amount"] . "<br>";
        }
    } else {
        echo "No transaction found with ID: " . $transid;
    }

    $stmt->close();
}

$conn->close();
?>
