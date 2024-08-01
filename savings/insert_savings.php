<?php
$servername = "localhost";
$username = "quickme1_4211";
$password = "csci4211";
$dbname = "dbvpny1qngaxgp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acct_no = $_POST['acct_no'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $balance = $_POST['balance'];
    $interest_rate = $_POST['interest_rate'];
    $transid = $_POST['transid'] ?? NULL;  // Assuming transaction ID might be optional
    $total_amount = $_POST['total_amount'] ?? 0;
    $date = date("Y-m-d H:i:s");  // Current date and time

    // Prepare the SQL statement
    $sql = "INSERT INTO savings (Acct_no, lastname, firstname, address, email, phone, Balance, interest_rate, TransID, total_amount, Date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssddiis", $acct_no, $lastname, $firstname, $address, $email, $phone, $balance, $interest_rate, $transid, $total_amount, $date);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "New savings account created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
