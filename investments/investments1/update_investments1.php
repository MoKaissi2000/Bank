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

    $stmt = $conn->prepare("UPDATE Investment SET lastname=?, firstname=?, address=?, email=?, phone=?, Balance=?, interest_rate=?, total_amount=? WHERE Acct_no=?");
    $stmt->bind_param("sssssdidi", $_POST['lastname'], $_POST['firstname'], $_POST['address'], $_POST['email'], $_POST['phone'], $_POST['Balance'], $_POST['interest_rate'], $_POST['total_amount'], $_POST['Acct_no']);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Investment account updated successfully.";
    } else {
        echo "Error updating account or account not found for your email.".$stmt->error;
    }

    $stmt->close();
$conn->close();
?>
