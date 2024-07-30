<?php
session_start();
require_once 'connection.php';

// Check if the admin user is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit;
}

$update_message = '';
$admin_username = $_SESSION['admin_username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current password from the database
    $stmt = $pdo->prepare('SELECT password FROM users WHERE username = ?');
    $stmt->execute([$admin_username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $current_password = $user['password'];

        // Check if old password matches
        if ($old_password === $current_password) {
            // Validate new password
            if ($new_password === $confirm_password && !empty($new_password)) {
                // Update password in the database
                $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE username = ?');
                if ($stmt->execute([$new_password, $admin_username])) {
                    $update_message = 'Password updated successfully';
                } else {
                    $update_message = 'Failed to update password';
                }
            } else {
                $update_message = 'New passwords do not match or are empty';
            }
        } else {
            $update_message = 'Old password is incorrect';
        }
    } else {
        $update_message = 'Admin not found';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <link rel="stylesheet" href="stylesst.css">
</head>
<body>
    <header>
        <h1 style="background-color: red; color: white; padding: 10px;">Admin Settings</h1>
    </header>
    <div class="container">
        <h2>Change Password</h2>
        
        <?php if ($update_message) { ?>
            <p><?php echo htmlspecialchars($update_message); ?></p>
        <?php } ?>

        <form method="POST" action="">
            <label for="old_password">Old Password:</label>
            <input type="password" id="old_password" name="old_password" required>
            
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <button type="submit">Update Password</button>
        </form>
    </div>
</body>
</html>
