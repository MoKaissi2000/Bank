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
    $email = $_SESSION['email']; // Ensure the user is adding an account for themselves
    $acct_no = $_POST['acct_no'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $balance = $_POST['balance'];
    $date = $_POST['date'];
    $transid = $_POST['transid'];

    $sql = "INSERT INTO checking (Acct_no, lastname, firstname, address, email, phone, Balance, Date, TransID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssdsi", $acct_no, $lastname, $firstname, $address, $email, $phone, $balance, $date, $transid);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "New checking account added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
