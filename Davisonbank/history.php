<?php
session_start(); // Start session to access session variables

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection script
require_once 'connection.php'; // Adjust path as needed

$user_id = $_SESSION['user_id']; // Get user ID from session

// Fetch transaction history
$deposits_query = "SELECT deposits, dates, descriptions FROM users WHERE user_id = ?";
$transfers_query = "SELECT transfers, dates, recipient FROM users WHERE user_id = ?";
$failed_query = "SELECT failed,dates, reason FROM users WHERE user_id = ?";
$reversed_query = "SELECT reversed, dates, transaction_id FROM users WHERE user_id = ?";

$deposits_stmt = $pdo->prepare($deposits_query);
$transfers_stmt = $pdo->prepare($transfers_query);
$failed_stmt = $pdo->prepare($failed_query);
$reversed_stmt = $pdo->prepare($reversed_query);

$deposits_stmt->execute([$user_id]);
$transfers_stmt->execute([$user_id]);
$failed_stmt->execute([$user_id]);
$reversed_stmt->execute([$user_id]);

$deposits = $deposits_stmt->fetchAll(PDO::FETCH_ASSOC);
$transfers = $transfers_stmt->fetchAll(PDO::FETCH_ASSOC);
$failed = $failed_stmt->fetchAll(PDO::FETCH_ASSOC);
$reversed = $reversed_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="stylest.css">
</head>
<body>
    <header class="header">
        <div class="logo">Transaction History</div>
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

    <div class="dashboard">
        <div class="table-section">
            <div class="table-header">Deposits History</div>
            <table id="deposits-history">
                <thead>
                    <tr>
                        <!-- Table Headers -->
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <!-- Add other headers as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($deposits as $deposit): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($deposit['dates']); ?></td>
                            <td><?php echo htmlspecialchars($deposit['deposits']); ?></td>
                            <td><?php echo htmlspecialchars($deposit['descriptions']); ?></td>
                            <!-- Add other columns as needed -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="table-section">
            <div class="table-header">Transfer History</div>
            <table id="transfer-history">
                <thead>
                    <tr>
                        <!-- Table Headers -->
                        <th>Date</th>
                        <th>Amount</th>
                        <th>To Account</th>
                        <!-- Add other headers as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transfers as $transfer): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transfer['dates']); ?></td>
                            <td><?php echo htmlspecialchars($transfer['transfers']); ?></td>
                            <td><?php echo htmlspecialchars($transfer['recipient']); ?></td>
                            <!-- Add other columns as needed -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="table-section">
            <div class="table-header">Failed Transactions</div>
            <table id="failed-transactions">
                <thead>
                    <tr>
                        <!-- Table Headers -->
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Reason</th>
                        <!-- Add other headers as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($failed as $transaction): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaction['dates']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['failed']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['reason']); ?></td>
                            <!-- Add other columns as needed -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="table-section">
            <div class="table-header">Reversed Transactions</div>
            <table id="reversed-transactions">
                <thead>
                    <tr>
                        <!-- Table Headers -->
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Original Transaction ID</th>
                        <!-- Add other headers as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reversed as $transaction): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaction['dates']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['reversed']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['transaction_id']); ?></td>
                            <!-- Add other columns as needed -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="scriptst.js"></script>
</body>
</html>
