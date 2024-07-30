<?php
// The new password you want to hash
$newPassword = 'Adminpassword123'; // Replace with the desired new admin password

// Hash the new password
$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

// Output the hashed password
echo "The hashed password is: " . $hashedPassword;
?>
