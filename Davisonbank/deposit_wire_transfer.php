<?php
session_start();
require_once 'connection.php'; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Retrieve user information if needed
$user_id = $_SESSION['user_id'];
// Optionally, fetch user details from the database if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wire Transfer Deposit</title>
    <link rel="stylesheet" href="stylesw.css">
    <script src="scriptsw.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="deposit-container">
            <h2>Wire Transfer Deposit</h2>
            <form id="wire-transfer-form" action="process_wire_transfer.php" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="account_number">Account Number:</label>
                    <input type="text" id="account_number" name="account_number" required>
                </div>
                <div class="form-group">
                    <label for="bank_name">Bank Name:</label>
                    <input type="text" id="bank_name" name="bank_name" required>
                </div>
                <div class="form-group">
                    <label for="routing_number">Routing Number:</label>
                    <input type="text" id="routing_number" name="routing_number" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="variable" id="amount" name="amount" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="reference">Reference:</label>
                    <input type="text" id="reference" name="reference">
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Davison Bank</p>
    </footer>
</body>
</html>
