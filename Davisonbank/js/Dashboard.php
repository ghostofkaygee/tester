<!-- dashboard.php -->

<?php
// Start session to access session variables
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection script (adjust as per your connection method)
require_once "connection.php"; // Replace with your database connection script

// Query to get user's account information (example query, adjust as per your database structure)
$user_id = $_SESSION['user_id'];
$userName = $_SESSION['username'];
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Example array of account types and initial balances (can be fetched dynamically from database)
$accountTypes = [
    ['name' => 'Savings Account', 'balance' => 15000],
    ['name' => 'Checking Account', 'balance' => 25000],
    ['name' => 'Investment Account', 'balance' => 100000],
];

// Example array of transfer types and their processes (can be fetched dynamically from database)
$transferTypes = [
    ['name' => 'Internal Transfer', 'process' => 'Transfer within the bank'],
    ['name' => 'External Transfer', 'process' => 'Transfer to another bank'],
];

// Example array of deposit types and their processes (can be fetched dynamically from database)
$depositTypes = [
    ['name' => 'Direct Deposit', 'process' => 'Automatic deposit from employer'],
    ['name' => 'Mobile Deposit', 'process' => 'Deposit using mobile app'],
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Dashboard</title>
    <link rel="stylesheet" href="stylesd.css"> <!-- Link to your CSS file -->
</head>
<body>
    <header class="header">
        <div class="container">
            <h1></h1>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li class="dropdown">
                        <a href="#">Account</a>
                        <div class="dropdown-content">
                            <a href="#">Profile</a>
                            <a href="#">Settings</a>
                            <a href="logout.php">Sign Out</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="dashboard">
        <div class="profile">
            <div class="profile-picture">
                <!-- Profile picture display -->
                <img src="allie2.jpg" alt="Profile Picture" id="profile-img">
                <!-- Upload button for profile picture -->
                <label for="upload" class="upload-btn">Upload</label>
                <input type="file" accept="image/*" id="upload" style="display: none;">
            </div>
            <h2>Welcome, <?php echo htmlspecialchars($userName); ?></h2>  <!-- Replace with PHP session username -->
        </div>
        
        <div class="accounts-container">
            <h2>Accounts</h2>
            <div class="accounts-slider">
                <div class="account">
                    <h3>Checking Account</h3>
                    <p class="balance">$5,000.00</p>
                </div>
                <div class="account">
                    <h3>Savings Account</h3>
                    <p class="balance">$10,000.00</p>
                </div>
                <div class="account">
                    <h3>Investment Account</h3>
                    <p class="balance">$50,000.00</p>
                </div>
            </div>
        </div>
        
        <div class="transactions">
            <h2>Transfers</h2>
            <div class="transactions-slider">
                <div class="transfer">
                    <h3>External Transfer</h3>
                    <p>Transfer funds to another bank</p>
                    <a href="#" class="transfer-link">Initiate Transfer</a>
                </div>
                <div class="transfer">
                    <h3>Internal Transfer</h3>
                    <p>Transfer funds within your accounts</p>
                    <a href="#" class="transfer-link">Initiate Transfer</a>
                </div>
            </div>
        </div>
        
        <div class="deposits">
            <h2>Deposits</h2>
            <div class="deposits-slider">
                <div class="deposit">
                    <h3>Check Deposit</h3>
                    <p>Deposit checks via mobile or scanner</p>
                    <a href="#" class="deposit-link">Initiate Deposit</a>
                </div>
                <div class="deposit">
                    <h3>Wire Transfer Deposit</h3>
                    <p>Deposit funds via wire transfer</p>
                    <a href="#" class="deposit-link">Initiate Deposit</a>
                </div>
            </div>
        </div>
    </div>

    <script src="scriptd.js"></script> <!-- Link to your existing JavaScript file -->
</body>
</html>
