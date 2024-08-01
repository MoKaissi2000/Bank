<?php
$servername = "localhost";
$username = "quickme1_4211";
$password = "csci4211";
$dbname = "dbvpny1qngaxgp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    $stmt = $conn->prepare("SELECT * FROM Investment WHERE email=?");
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Account No: " . $row["Acct_no"] . " - Name: " . $row["firstname"] . " " . $row["lastname"] .
                 " - Email: " . $row["email"] . " - Phone: " . $row["phone"] . " - Balance: $" . $row["Balance"] .
                 " - Date: " . $row["Date"] . " - TransID: " . $row["TransID"] . " - Interest Rate: " . $row["interest_rate"] . 
                 " - Total Amount: $" . $row["total_amount"] . "<br>";
        }
    } else {
        echo "No accounts found.";
    }
    $stmt->close();
    $conn->close();
}
?>
