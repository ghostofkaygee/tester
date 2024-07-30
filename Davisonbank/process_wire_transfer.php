<?php
session_start();
require_once 'connection.php'; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $account_number = $_POST['account_number'];
    $bank_name = $_POST['bank_name'];
    $routing_number = $_POST['routing_number'];
    $amount = $_POST['amount'];
    $reference = isset($_POST['reference']) ? $_POST['reference'] : '';

    // Validate input
    if (empty($account_number) || empty($bank_name) || empty($routing_number) || empty($amount) || !is_numeric($amount) || $amount <= 0) {
        echo "Invalid input.";
        exit;
    }

    // Insert the wire transfer details into the database
    $stmt = $pdo->prepare("INSERT INTO wire_transfers (account_number, bank_name, routing_number, amount, reference, user_id, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$account_number, $bank_name, $routing_number, $amount, $reference, $_SESSION['user_id']]);

    echo "Wire transfer request submitted successfully.";
    // Redirect or show a success message
    header('Location: deposit_wire_sucess.php');
    exit;
} else {
    echo "Invalid request.";
}
?>
