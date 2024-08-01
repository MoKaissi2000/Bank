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

    $sql = "SELECT * FROM checking WHERE Acct_no = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $acct_no, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Account No: " . $row["Acct_no"] .
                 " - Last Name: " . $row["lastname"] .
                 " - First Name: " . $row["firstname"] .
                 " - Address: " . $row["address"] .
                 " - Email: " . $row["email"] .
                 " - Phone: " . $row["phone"] .
                 " - Balance: $" . $row["Balance"] .
                 " - Date: " . $row["Date"] .
                 " - TransID: " . $row["TRansID"] . "<br>";
        }
    } else {
        echo "No checkings account found with that account number for your email.";
    }

    $stmt->close();
}
$conn->close();
?>
