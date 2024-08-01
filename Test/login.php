<?php
session_start();
$servername = "localhost";
$username = "quickme1_4211";
$password = "csci4211";
$dbname = "dbvpny1qngaxgp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['role']) && $_POST['role'] === 'admin') {
    header("Location: display_admin.php");  // Redirect to admin display page
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userid'])) {
    $userid = $_POST['userid'];

    // Prepare SQL to search the userid in the login table and get associated email
    $sql = "SELECT email FROM login_tbl WHERE userid = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];  // Store email in session
        header("Location: dashboard4.php");  // Redirect to dashboard
        exit();
    } else {
        $error = "No account found, please register.";
        header("Location: register2.php");  // Redirect to registration form
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login to Your Account</h2>
<form method="post" action="">
    Role: <select name="role" required>
              <option value="">Select Role</option>
              <option value="user">User</option>
              <option value="admin">Administrator</option>
          </select><br>
    User ID: <input type="number" name="userid" required><br>
    <input type="submit" value="Login">
</form>
<?php if (!empty($error)) echo "<p>$error</p>"; ?>
</body>
</html>
