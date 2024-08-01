<?php
session_start();

// Replace with actual database connection details
$servername = "localhost";
$username = "quickme1_4211";
$password = "csci4211";
$dbname = "dbvpny1qngaxgp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function createAccount($conn, $accountType, $data) {
    // Prepare a SQL statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO `$accountType` (lastname, firstname, address, email, phone, Balance, Date, interest_rate, total_amount) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)");
    
    // The types of the variables in order (s = string, d = double)
    $stmt->bind_param("ssssdd", $data['lastname'], $data['firstname'], $data['address'], $data['email'], $data['phone'], $data['balance'], $data['interest_rate'], $data['total_amount']);
    
    // Execute the statement
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Account created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accountType'])) {
    // Sanitize POST array
    $postData = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $accountType = $_POST['accountType'];

    // Data array for the account, should be filled with the actual input fields
    $accountData = [
        'lastname' => $postData['lastname'],
        'firstname' => $postData['firstname'],
        'address' => $postData['address'],
        'email' => $postData['email'],
        'phone' => $postData['phone'],
        'balance' => $postData['balance'],
        'interest_rate' => isset($postData['interest_rate']) ? $postData['interest_rate'] : 0,
        'total_amount' => isset($postData['total_amount']) ? $postData['total_amount'] : 0
    ];

    // Assuming you're storing account type as table names
    createAccount($conn, $accountType, $accountData);
}

// Close the database connection
$conn->close();
?>
