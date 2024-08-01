<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script>
    function showLinks(accountType) {
        var htmlContent = '';
        var baseAccountPath = '../' + accountType + '/' + accountType + '1/';
        var baseTransactionPath = '../' + accountType + '/';
        var baseTransaction1Path = '../' + accountType + '_transaction/';

        // Account management links
        htmlContent += '<a href="' + baseAccountPath + 'display_' + accountType + '1.html">Display Accounts</a><br>';
        htmlContent += '<a href="' + baseAccountPath + 'update_' + accountType + '1.html">Update Account</a><br>';
        htmlContent += '<a href="' + baseAccountPath + 'delete_' + accountType + '1.html">Delete Account</a><br>';
        htmlContent += '<a href="' + baseAccountPath + 'search_' + accountType + '1.html">Search Account</a><br>';
        htmlContent += '<a href="' + baseAccountPath + 'insert_' + accountType + '1.html">Create Account</a><br>';

        // Transaction links
        htmlContent += '<a href="' + baseTransactionPath + 'deposit_' + accountType + '_transaction.html">Deposit to Account</a><br>';
        htmlContent += '<a href="' + baseTransactionPath + 'withdraw_' + accountType + '_transaction.html">Withdraw from Account</a><br>';
        htmlContent += '<a href="' + baseTransactionPath + 'transfer_' + accountType + '_transaction.html">Transfer between Accounts</a><br>';
        
        htmlContent += '<a href="' + baseTransaction1Path + 'display_' + accountType +'_transaction.html">Display all transactions</a><br>';
        htmlContent += '<a href="' + baseTransaction1Path + 'update_' + accountType + '_transaction.html">Update a transaction</a><br>';
        htmlContent += '<a href="' + baseTransaction1Path + 'delete_' + accountType + '_transaction.html">Delete a transaction</a><br>';
        htmlContent += '<a href="' + baseTransaction1Path + 'search_' + accountType + '_transaction.html">Search a transaction</a><br>';
        if (accountType !== 'checkings') {
            htmlContent += '<a href="' + baseTransactionPath + 'interest_calculations_' + accountType + '_transaction.html">Calculate Interest</a><br>';
        }

        document.getElementById('links').innerHTML = htmlContent;
    }
    </script>
</head>
<body>
<h1>Welcome to Your Dashboard</h1>
<button onclick="showLinks('checkings')">Checkings Accounts</button>
<button onclick="showLinks('savings')">Savings Accounts</button>
<button onclick="showLinks('investments')">Investment Accounts</button>

<div id="links">
    <!-- Links will be displayed here based on selection -->
</div>

<!-- Logout button -->
<form action="logout.php" method="post" style="margin-top: 20px;">
    <input type="submit" value="Logout">
</form>

</body>
</html>
