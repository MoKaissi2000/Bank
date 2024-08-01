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

    // Check the last withdrawal date and balance from the Investments table
    $checkSql = "SELECT Balance, (SELECT MAX(trans_date) FROM investment_transactions WHERE acct_no = ? AND trans_type = 'withdrawal') as last_withdrawal FROM Investment WHERE Acct_no = ?";
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
            $updateSql = "UPDATE Investment SET Balance = Balance - ? WHERE Acct_no = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("di", $amount, $acct_no);
            $updateStmt->execute();

            // Log the withdrawal transaction
            $trans_type = 'withdrawal';
            $trans_date = $currentDate->format('Y-m-d');
            $trans_amount = $amount; // define this to be the same as $amount
            $lastname = ''; // Assuming you have these values or else fetch them like the account details
            $firstname = '';
            $phone = '';
            $sql_trans = "INSERT INTO investment_transactions (trans_type, trans_date, trans_amount, acct_no, lastname, firstname, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_trans = $conn->prepare($sql_trans);
            $stmt_trans->bind_param("ssdiss", $trans_type, $trans_date, $trans_amount, $acct_no, $lastname, $firstname, $phone);
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
