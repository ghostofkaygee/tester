<?php
session_start();
require_once 'connection.php'; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Retrieve the latest wire transfer details for the user
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM wire_transfers WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->execute([$user_id]);
$transfer = $stmt->fetch();

// Check if the transfer details are retrieved
if (!$transfer) {
    echo "No wire transfer details found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wire Transfer Success</title>
    <link rel="stylesheet" href="stylesws.css">
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
        <div class="success-container">
            <h2>Wire Transfer Successful</h2>
            <p>Your wire transfer request has been submitted successfully.</p>
            <h3>Transaction Details:</h3>
            <ul>
                <li><strong>Account Number:</strong> <?php echo htmlspecialchars($transfer['account_number']); ?></li>
                <li><strong>Bank Name:</strong> <?php echo htmlspecialchars($transfer['bank_name']); ?></li>
                <li><strong>Routing Number:</strong> <?php echo htmlspecialchars($transfer['routing_number']); ?></li>
                <li><strong>Amount:</strong> $<?php echo number_format($transfer['amount'], 2); ?></li>
                <li><strong>Reference:</strong> <?php echo htmlspecialchars($transfer['reference']); ?></li>
                <li><strong>Date:</strong> <?php echo htmlspecialchars($transfer['created_at']); ?></li>
            </ul>
            <a href="dashboard.php" class="back-link">Back to Dashboard</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Davison Bank</p>
    </footer>
</body>
</html>
