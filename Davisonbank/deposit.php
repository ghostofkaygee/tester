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
    <title>Check Deposit</title>
    <link rel="stylesheet" href="stylesde.css">
    <script src="scriptsde.js" defer></script>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="deposit.php">Deposit</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
    <div class="container">
        <h2>Check Deposit</h2>
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <form method="POST" action="process_deposit.php" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="check_number">Check Number:</label>
                <input type="text" id="check_number" name="check_number" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="variable" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes"></textarea>
            </div>
            <div class="form-group">
                <label for="check_image">Check Image:</label>
                <input type="file" id="check_image" name="check_image" accept="image/*" required>
            </div>
            <button type="submit">Submit Deposit</button>
        </form>
    </div>
</body>
</html>
