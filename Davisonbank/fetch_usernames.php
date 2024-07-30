<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit;
}

require_once 'connection.php';

try {
    $stmt = $pdo->query('SELECT username FROM users');
    $usernames = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($usernames);
} catch (PDOException $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
