<?php
session_start();
require_once 'connection.php';

// Check if the admin user is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit;
}

// Check if the form data is set
if (isset($_POST['transfer_id']) && isset($_POST['action']) && in_array($_POST['action'], ['approve', 'reject'])) {
    $transfer_id = $_POST['transfer_id'];
    $action = $_POST['action'];

    // Prepare the SQL statement to update the action
    try {
        $stmt = $pdo->prepare('UPDATE external_transfers SET status = :status WHERE id = :id');
        
        // Set status based on action
        $status = ($action === 'approve') ? 'Approved' : 'Rejected';
        
        // Execute the statement with bound parameters
        $stmt->execute([':status' => $status, ':id' => $transfer_id]);

        // Redirect back to the external transfers page
        header("Location: admin_external_transfers.php");
        exit;
    } catch (PDOException $e) {
        // Handle errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
