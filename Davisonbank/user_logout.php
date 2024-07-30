<?php
session_start();

// Destroy all session data
session_destroy();

// Redirect to user login page
header("Location: home.html");
exit;
?>
