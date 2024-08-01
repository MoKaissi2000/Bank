<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

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

    $sql = "INSERT INTO savings (Acct_no, lastname, firstname, address, email, phone, Balance, Date, TransID, interest_rate, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssdssid", $acct_no, $lastname, $firstname, $address, $email, $phone, $balance, $date, $transid, $interest_rate, $total_amount);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "New savings account added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
