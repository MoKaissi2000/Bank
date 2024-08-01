<?php
session_start();
$servername = "localhost";
$username = "quickme1_4211";
$password = "csci4211";
$dbname = "dbvpny1qngaxgp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $testname = filter_input(INPUT_POST, 'testquestion', FILTER_SANITIZE_STRING);
    $testanswer = filter_input(INPUT_POST, 'testanswer', FILTER_SANITIZE_STRING);
    $usertype = filter_input(INPUT_POST, 'usertype', FILTER_SANITIZE_STRING);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO login_tbl (userid, pssword, lastname, firstname, address, phone, email, testquestion, testanswer, usertype) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error); 
    }
    
    $stmt->bind_param("ssssssssss", $userid, $password, $lastname, $firstname, $address, $phone, $email, $testname, $testanswer, $usertype);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Account created successfully.";
        // Redirect to login page or dashboard as appropriate
        header("Location: login.php");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Account</title>
</head>
<body>
<h2>Register New Account</h2>
<?php if (!empty($error)) echo "<p>$error</p>"; ?>
<form method="post" action="register2.php">
    User ID: <input type="number" name="userid" required><br>
    Password: <input type="password" name="password" required><br> 
    Last Name: <input type="text" name="lastname" required><br>
    First Name: <input type="text" name="firstname" required><br>
    Address: <input type="text" name="address" required><br>
    Phone: <input type="text" name="phone" required><br>
    Email: <input type="email" name="email" required><br>
    Test Question: <input type="text" name="testquestion" required><br>
    Test Answer: <input type="text" name="testanswer" required><br>
    User Type: <input type="text" name="usertype" required><br>
    <input type="submit" value="Register">
</form>
</body>
</html>
