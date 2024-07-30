<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_number = $_POST['check_number'];
    $amount = $_POST['amount'];
    $notes = $_POST['notes'];

    // File upload handling
    if (isset($_FILES['check_image']) && $_FILES['check_image']['error'] == 0) {
        $target_dir = "uploads/check_images/";
        $target_file = $target_dir . basename($_FILES["check_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["check_image"]["tmp_name"]);
        if ($check === false) {
            $error = "File is not an image.";
        }

        // Check file size (limit to 5MB)
        if ($_FILES["check_image"]["size"] > 5000000) {
            $error = "Sorry, your file is too large.";
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        if (!isset($error)) {
            if (move_uploaded_file($_FILES["check_image"]["tmp_name"], $target_file)) {
                // Insert deposit details into the database
                $query = "INSERT INTO check_deposits (user_id, check_number, amount, notes, check_image) VALUES (?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($query);
                $result = $stmt->execute([$user_id, $check_number, $amount, $notes, $target_file]);

                if ($result) {
                    header("Location: deposit_success.php");
                    exit();
                } else {
                    $error = "Failed to submit deposit. Please try again.";
                }
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $error = "No file was uploaded or there was an error uploading the file.";
    }

    if (isset($error)) {
        header("Location: deposit.php?error=" . urlencode($error));
        exit();
    }
}
?>
