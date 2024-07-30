<?php
session_start();
require_once 'connection.php'; // Ensure this path is correct

// Check if the admin user is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="stylesadd.css">
</head>
<body>
    <div class="admin-dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Dashboard</h2>
            <ul>
                <li><a href="#" data-content="manage-users">Manage Users</a></li>
                <li class="has-submenu">
                    <a href="#" data-content="manage-transfers">Manage Transfers</a>
                    <ul class="submenu">
                        <li><a href="#" data-content="internal-transfers">Internal Transfers</a></li>
                        <li><a href="admin_external_transfers.php" data-content="external-transfers">External Transfers</a></li>
                    </ul>
                </li>
                <li><a href="#" data-content="admin-profile">Admin Profile</a></li>
                <li><a href="#" data-content="settings">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Welcome to the Admin Dashboard</h1>
            </div>
            <div id="content-area">
                <!-- Content will be loaded here based on selection -->
                <p>Select an option from the sidebar to view content.</p>
            </div>
        </div>
    </div>

    <script src="scriptsadmin.js"></script>
</body>
</html>
