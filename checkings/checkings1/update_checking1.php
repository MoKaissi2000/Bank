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
    $email = $_SESSION['email']; 
    $acct_no = $_POST['acct_no'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $balance = $_POST['balance'];
    $date = $_POST['date'];
    $transid = $_POST['transid'];

    $sql = "UPDATE checking SET lastname = ?, firstname = ?, address = ?, phone = ?, Balance = ?, Date = ?, TransID = ? WHERE Acct_no = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdsisi", $lastname, $firstname, $address, $phone, $balance, $date, $transid, $acct_no, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Checking account updated successfully.";
    } else {
        echo "Error updating account or account not found for your email.";
    }

    $stmt->close();
}
$conn->close();
?>
