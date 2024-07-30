<?php
session_start(); // Start the session if you need to use session variables

// Set the target directory for profile pictures
$target_dir = "uploads/";

// Ensure the uploads directory exists
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_photo'])) {
    $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }

    // Check file size (5MB maximum)
    if ($_FILES["profile_photo"]["size"] > 5000000) {
        echo "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br>";
    } else {
        // Save the file with a unique name to prevent overwriting
        $newFileName = $target_dir . uniqid() . '.' . $imageFileType;

        if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $newFileName)) {
            echo "The file " . basename($_FILES["profile_photo"]["name"]) . " has been uploaded.<br>";
            // Save the file path in the session or database as needed
            $_SESSION['profile_photo'] = $newFileName;

            // Redirect to the profile page or any other page
            header('Location: profile.php');
            exit;
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
} else {
    echo "Invalid request.<br>";
}

// Additional debug information
echo '<pre>';
print_r($_FILES);
echo '</pre>';
?>
