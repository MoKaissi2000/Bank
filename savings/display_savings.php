<?php
$servername = "localhost";
$username = "quickme1_4211";
$password = "csci4211";
$dbname = "dbvpny1qngaxgp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Prepare and execute the query to select all records
$sql = "SELECT * FROM savings";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Account No: " . $row["Acct_no"] . " - Last Name: " . $row["lastname"] . 
             " - First Name: " . $row["firstname"] . " - Address: " . $row["address"] .
             " - Email: " . $row["email"] . " - Phone: " . $row["phone"] .
             " - Balance: $" . $row["Balance"] . " - Date: " . $row["Date"] .
             " - Transaction ID: " . $row["TRansID"] . "<br>";
    }
} else {
    echo "No accounts found.";
}
$conn->close();
?>
