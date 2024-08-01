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
    $Acct_no = $_POST['Acct_no'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $balance = $_POST['balance'];
    $date = date('Y-m-d', strtotime($date));
    $TRansID = $_POST['TRansID'];

    // Prepare the SQL statement
    $sql = "INSERT INTO checking (Acct_no, lastname, firstname, address, email, phone, balance, date, TRansID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssdsi", $Acct_no, $lastname, $firstname, $address, $email, $phone, $balance, $date, $TRansID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "New checking account created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
