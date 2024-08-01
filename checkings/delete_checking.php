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

    // Prepare the SQL statement
    $sql = "DELETE FROM checking WHERE Acct_no=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $acct_no);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Checking account deleted successfully.";
    } else {
        echo "Error or no account found with that number.";
    }
    $stmt->close();
}
$conn->close();
?>
