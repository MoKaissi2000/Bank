<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");  // Redirect to login if not logged in
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

$currentDate = date('Y-m-d');  // Current date for fetching today's transactions

function displayTransactions($conn, $table, $currentDate) {
    $sql = "SELECT * FROM " . $table . " WHERE DATE(trans_date) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $currentDate);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Transactions for " . ucfirst(str_replace("_transactions", "", $table)) . "</h2>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Trans ID: " . $row["TRansID"] . 
                 ", Type: " . $row["trans_type"] . 
                 ", Date: " . $row["trans_date"] .
                 ", Amount: $" . $row["trans_amount"] .
                 ", Last Name: " . $row["lastname"] .
                 ", First Name: " . $row["firstname"] .
                 ", Phone: " . $row["phone"] . "<br>";
        }
    } else {
        echo "No transactions found for today.<br>";
    }
    $stmt->close();
}

// Display transactions for each account type
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daily Transaction Summary</title>
</head>
<body>
    <h1>Daily Summary for <?php echo $currentDate; ?></h1>
    <?php 
        displayTransactions($conn, 'checking_transactions', $currentDate); 
        displayTransactions($conn, 'savings_transactions', $currentDate); 
        displayTransactions($conn, 'investment_transactions', $currentDate);
    ?>
</body>
</html>
<?php
$conn->close();
?>
