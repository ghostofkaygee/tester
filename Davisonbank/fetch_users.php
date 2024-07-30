<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.html");
    exit;
}

if (!isset($_GET['username'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Username parameter is required']);
    exit;
}

require_once 'connection.php';
$username = $_GET['username'];

try {
    $stmt = $pdo->prepare('SELECT username FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        header('Content-Type: application/json');
        echo json_encode($user);
    } else {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'User not found']);
    }
} catch (PDOException $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
