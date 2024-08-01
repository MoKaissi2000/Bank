<?php
$servername = "localhost";
$username = "quickme1_4211";
$password = "csci4211";
$dbname = "dbvpny1qngaxgp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Display all Checkings
echo "<h2>Checkings Accounts</h2>";
$checkingsSql = "SELECT * FROM checkings";
displayTable($checkingsSql, $conn);

// Display all Savings
echo "<h2>Savings Accounts</h2>";
$savingsSql = "SELECT * FROM savings";
displayTable($savingsSql, $conn);

// Display all Investments
echo "<h2>Investments Accounts</h2>";
$investmentsSql = "SELECT * FROM investment";
displayTable($investmentsSql, $conn);

function displayTable($sql, $conn) {
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Account No: " . $row["Acct_no"] . " - Last Name: " . $row["lastname"] .
                 " - First Name: " . $row["firstname"] . " - Email: " . $row["email"] .
                 " - Phone: " . $row["phone"] . " - Balance: $" . $row["Balance"] .
                 " - Date: " . $row["Date"] . " - TransID: " . $row["TransID"] . "<br>";
        }
    } else {
        echo "No accounts found.<br>";
    }
}

$conn->close();
?>
