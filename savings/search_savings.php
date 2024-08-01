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
    $sql = "SELECT * FROM savings WHERE Acct_no=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $acct_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Account No: " . $row["Acct_no"]. " - Last Name: " . $row["lastname"]. " - First Name: " . $row["firstname"]. 
                 " - Address: " . $row["address"] . " - Email: " . $row["email"]. " - Phone: " . $row["phone"] . 
                 " - Balance: $" . $row["Balance"]. " - Interest Rate: " . $row["interest_rate"] . "% - Transaction ID: " . $row["TransID"] .
                 " - Total Amount: $" . $row["total_amount"] . "<br>";
        }
    } else {
        echo "No results found";
    }
    $stmt->close();
}
$conn->close();
?>
