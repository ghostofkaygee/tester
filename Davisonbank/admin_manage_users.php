<?php
session_start();
require_once 'connection.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the admin user is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit;
}

// Fetch users for the dropdown
$query = "SELECT username FROM users";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize user details to null
$user_details = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    // Get the form data
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $checkingbalance = $_POST['checkingbalance'];
    $savingbalance = $_POST['savingsbalance'];
    $investmentbalance = $_POST['Investmentbalance'];
    $deposits = $_POST['deposits'];
    $transfers = $_POST['transfers'];
    $failed = $_POST['failed'];
    $reversed = $_POST['reversed'];
    $dates = $_POST['dates'];
    $descriptions = $_POST['descriptions'];
    $reason = $_POST['reason'];
    $recipient = $_POST['recipient'];
    $transaction_id = $_POST['transaction_id'];

    // Update user details in the database
    $query = "UPDATE users SET password = ?, email = ?, checkingbalance = ?, savingsbalance = ?, Investmentbalance = ?, deposits = ?, transfers = ?, failed = ?, reversed = ?, dates = ?, descriptions = ?, reason = ?, recipient = ?, transaction_id = ? WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    if ($stmt->execute([$password, $email, $checkingbalance, $savingbalance, $investmentbalance, $deposits, $transfers, $failed, $reversed, $dates, $descriptions, $reason, $recipient, $transaction_id, $user_id])) {
        $update_message = 'User details updated successfully';
    } else {
        $update_message = 'Failed to update user details';
    }
}


// Fetch user details if a username is selected
if (isset($_GET['username']) && !empty($_GET['username'])) {
    $username = $_GET['username'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user_details = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="stylesadm.css">
    <script src="scriptsdm.js" defer></script>
</head>
<body>
    <header>
        <h1 style="background-color: red; color: white; padding: 10px;">Manage Users</h1>
    </header>
    <div class="container">
        <h2>Manage Users</h2>

        <form id="select-user-form" action="admin_manage_users.php" method="GET">
            <label for="username">Select User:</label>
            <select id="username" name="username" onchange="this.form.submit()">
                <option value="">Select a user</option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo htmlspecialchars($user['username']); ?>" <?php echo (isset($user_details) && $user_details['username'] == $user['username']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($user['username']); ?>
                    </option>
                <?php } ?>
            </select>
        </form>
        <?php if (isset($update_message)) { ?>
            <p><?php echo htmlspecialchars($update_message); ?></p>
        <?php } ?>

        <?php if ($user_details) { ?>
            <div id="user-details">
                <h2>User: <?php echo htmlspecialchars($user_details['username']); ?></h2>
                <form id="update-user-form" action="admin_manage_users.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_details['user_id']); ?>">
                    <table>
                        <!-- Add fields for user details here -->
                        <tr><td>Username:</td><td><input type="text" name="username" value="<?php echo htmlspecialchars($user_details['username']); ?>" readonly></td></tr>
                        <tr><td>Password:</td><td><input type="text" name="password" value="<?php echo htmlspecialchars($user_details['password']); ?>"></td></tr>
                        <tr><td>Email:</td><td><input type="text" name="email" value="<?php echo htmlspecialchars($user_details['email']); ?>"></td></tr>
                        <tr><td>checkingbalance:</td><td><input type="text" name="checkingbalance" value="<?php echo htmlspecialchars($user_details['checkingbalance']); ?>"></td></tr>
                        <tr><td>savingsbalance:</td><td><input type="text" name="savingsbalance" value="<?php echo htmlspecialchars($user_details['savingsbalance']); ?>"></td></tr>
                        <tr><td>Investmentbalance:</td><td><input type="text" name="Investmentbalance" value="<?php echo htmlspecialchars($user_details['Investmentbalance']); ?>"></td></tr>
                        <tr><td>deposits:</td><td><input type="text" name="deposits" value="<?php echo htmlspecialchars($user_details['deposits']); ?>"></td></tr>
                        <tr><td>Transfers:</td><td><input type="text" name="transfers" value="<?php echo htmlspecialchars($user_details['transfers']); ?>"></td></tr>
                        <tr><td>failed:</td><td><input type="text" name="failed" value="<?php echo htmlspecialchars($user_details['failed']); ?>"></td></tr>
                        <tr><td>reversed:</td><td><input type="text" name="reversed" value="<?php echo htmlspecialchars($user_details['reversed']); ?>"></td></tr>
                        <tr><td>dates:</td><td><input type="text" name="dates" value="<?php echo htmlspecialchars($user_details['dates']); ?>"></td></tr>
                        <tr><td>descriptions:</td><td><input type="text" name="descriptions" value="<?php echo htmlspecialchars($user_details['descriptions']); ?>"></td></tr>
                        <tr><td>reason:</td><td><input type="text" name="reason" value="<?php echo htmlspecialchars($user_details['reason']); ?>"></td></tr>
                        <tr><td>recipient:</td><td><input type="text" name="recipient" value="<?php echo htmlspecialchars($user_details['recipient']); ?>"></td></tr>
                        <tr><td>transaction_id:</td><td><input type="text" name="transaction_id" value="<?php echo htmlspecialchars($user_details['transaction_id']); ?>"></td></tr>

                        <!-- Include other fields here -->
                    </table>
                    <button type="submit">Update User</button>
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>