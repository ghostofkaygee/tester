<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch external transfers
$external_query = "SELECT 'external' AS type, recipient_name, recipient_bank, account_number, swift_code, amount, notes, status, created_at 
                   FROM external_transfers 
                   WHERE user_id = ? 
                   ORDER BY created_at DESC";
$external_stmt = $pdo->prepare($external_query);
$external_stmt->execute([$user_id]);
$external_transfers = $external_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch internal transfers
$internal_query = "SELECT 'internal' AS type, recipient_user_id, NULL AS recipient_bank, NULL AS account_number, NULL AS swift_code, amount, notes, status, created_at 
                   FROM internal_transfers 
                   WHERE user_id = ? 
                   ORDER BY created_at DESC";
$internal_stmt = $pdo->prepare($internal_query);
$internal_stmt->execute([$user_id]);
$internal_transfers = $internal_stmt->fetchAll(PDO::FETCH_ASSOC);

// Merge and sort transactions by date
$transactions = array_merge($external_transfers, $internal_transfers);
usort($transactions, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

echo json_encode($transactions);
?>
