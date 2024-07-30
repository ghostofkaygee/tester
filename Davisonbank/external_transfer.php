<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>External Transfer</title>
    <link rel="stylesheet" href="stylese.css">
</head>
<body>
    <header class="header">
        <div class="logo">External Transfers </div>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="history.php">Transaction History</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Account</a>
                    <div class="dropdown-content">
                        <a href="profile.php">Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>External Bank Transfer</h2>
        <form action="process_transfer.php" method="POST" id="transfer-form">
            <div class="form-group">
                <label for="recipient-name">Recipient's Name:</label>
                <input type="text" id="recipient-name" name="recipient_name" required>
            </div>
            <div class="form-group">
                <label for="recipient-bank">Recipient's Bank:</label>
                <input type="text" id="recipient-bank" name="recipient_bank" required>
            </div>
            <div class="form-group">
                <label for="account-number">Recipient's Account Number:</label>
                <input type="text" id="account-number" name="account_number" required>
            </div>
            <div class="form-group">
                <label for="swift-code">Recipient's Bank SWIFT Code:</label>
                <input type="text" id="swift-code" name="swift_code" required>
            </div>
            <div class="form-group">
                <label for="amount">Transfer Amount:</label>
                <input type="number" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="notes">Notes (Optional):</label>
                <textarea id="notes" name="notes"></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Submit Transfer</button>
            </div>
        </form>
    </div>

    <script src="scriptse.js"></script>
</body>
</html>
