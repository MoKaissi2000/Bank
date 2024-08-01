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
    $transid = $_POST['transid'];
    $total_amount = $_POST['total_amount'];

    // Prepare the SQL statement
    $sql = "UPDATE savings SET lastname=?, firstname=?, address=?, email=?, phone=?, Balance=?, interest_rate=?, TransID=?, total_amount=? WHERE Acct_no=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssdidis", $lastname, $firstname, $address, $email, $phone, $balance, $interest_rate, $transid, $total_amount, $acct_no);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Savings account updated successfully.";
    } else {
        echo "Error updating account or account not found for your email.";
    }

    $stmt->close();
}
$conn->close();
?>
