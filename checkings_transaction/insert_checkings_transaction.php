<?php
$servername = "localhost";
$username = "quickme1_4211";
$password = "csci4211";
$dbname = "dbvpny1qngaxgp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transid = $_POST['transid'];
    $trans_type = $_POST['trans_type'];
    $trans_date = $_POST['trans_date'];
    $trans_amount = $_POST['trans_amount'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO checking_transactions (transid, trans_type, trans_date, trans_amount, lastname, firstname, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $transid, $trans_type, $trans_date, $trans_amount, $lastname, $firstname, $phone);
    $stmt->execute();

    if ($stmt->execute()) {
        echo "New transaction inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
