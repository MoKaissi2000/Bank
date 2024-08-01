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
    $acct_no = $_POST['acct_no'];
    $amount = $_POST['amount'];

    // Check the last withdrawal date and balance from the savings table
    $checkSql = "SELECT Balance, (SELECT MAX(trans_date) FROM savings_transactions WHERE Acct_no = ? AND trans_type = 'withdrawal') as last_withdrawal FROM savings WHERE Acct_no = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $acct_no, $acct_no);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        $lastWithdrawal = new DateTime($data['last_withdrawal'] ?? '1900-01-01'); // Defaulting to a very old date if null
        $currentDate = new DateTime();
        $interval = $lastWithdrawal->diff($currentDate);

        // Ensure that it has been at least one year and there is enough balance
        if ($interval->y >= 1 && $data['Balance'] >= $amount) {
            // Proceed with withdrawal
            $updateSql = "UPDATE savings SET Balance = Balance - ? WHERE Acct_no = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("di", $amount, $acct_no);
            $updateStmt->execute();

            // Log the withdrawal transaction
            $transid = uniqid(); // Generate a unique transaction ID
            $trans_type = 'withdrawal';
            $trans_date = $currentDate->format('Y-m-d');
            $lastname = ''; // Assuming you have these values or else fetch them like the account details
            $firstname = '';
            $phone = '';
            $sql_trans = "INSERT INTO savings_transactions (transid, trans_type, trans_date, trans_amount, lastname, firstname, phone) SELECT ?, ?, ?, ?, lastname, firstname, phone FROM savings WHERE Acct_no = ?";
            $stmt_trans = $conn->prepare($sql_trans);
            $stmt_trans->bind_param("ssdis", $transid, $trans_type, $trans_date, $amount, $acct_no);
            $stmt_trans->execute();

            if ($updateStmt->affected_rows > 0 && $stmt_trans->affected_rows > 0) {
                echo "Withdrawal successful.";
            } else {
                echo "Error: " . $updateStmt->error . " " . $stmt_trans->error;
            }

            $updateStmt->close();
            $stmt_trans->close();
        } else {
            echo "Unable to withdraw. It has not been a year since the last withdrawal or insufficient funds.";
        }
    } else {
        echo "No account found or no previous withdrawals.";
    }

    $checkStmt->close();
}
$conn->close();
?>
