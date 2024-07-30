<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="stylesr.css">
    <script src="scriptsr.js" defer></script>
</head>
<body>
    <header class="header">
        <div class="logo">My Bank</div>
        <nav class="nav">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="transactionhistory.php">Transfer requests</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Transaction History</h2>
        <table id="transaction-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Recipient</th>
                    <th>Bank</th>
                    <th>Account Number</th>
                    <th>SWIFT Code</th>
                    <th>Amount</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <!-- Transactions will be loaded here by JavaScript -->
            </tbody>
        </table>
    </div>
</body>
</html>
