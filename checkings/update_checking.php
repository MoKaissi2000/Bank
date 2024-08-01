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
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $balance = $_POST['balance'];
    $date = $_POST['date'];
    $transid = $_POST['transid'];

    // Prepare the SQL statement
    $sql = "UPDATE checking SET lastname=?, firstname=?, address=?, email=?, phone=?, Balance=?, Date=?, TransID=? WHERE Acct_no=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssdsi", $lastname, $firstname, $address, $email, $phone, $balance, $date, $transid, $acct_no);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Checking account updated successfully.";
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
