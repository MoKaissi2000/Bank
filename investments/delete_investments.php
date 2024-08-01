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
    $email = $_SESSION['email'];

    $sql = "DELETE FROM Investment WHERE Acct_no = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $acct_no, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Investment account deleted successfully.";
    } else {
        echo "Error deleting account or account not found for your email.";
    }

    $stmt->close();
}
$conn->.close();
?>
