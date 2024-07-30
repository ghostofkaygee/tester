<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all users except the logged-in user for recipient options
$query = "SELECT user_id, username FROM users WHERE user_id != ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Transfer</title>
    <link rel="stylesheet" href="stylesi.css">
</head>
<body>
    <header class="header">
        <div class="logo">Davison Bank</div>
        <nav class="nav">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="transaction_history.php">Transaction History</a></li>
                <li><a href="internal_transfer.php">Internal Transfer</a></li>
                <li><a href="external_transfer.php">External Transfer</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Internal Transfer</h2>
        <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="process_internal_transfer.php">
        <label for="recipient_username">Recipient Username:</label>
        <input type="text" id="recipient_username" name="recipient_username" required><br>

        <label for="amount">Amount:</label>
        <input type="variable" id="amount" name="amount" required><br>

        <label for="notes">Notes:</label>
        <textarea id="notes" name="notes"></textarea><br>

        <input type="submit" value="Submit">
    </form>
    </div>
</body>
</html>
