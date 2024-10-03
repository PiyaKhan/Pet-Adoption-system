<?php
session_start();
session_unset(); // Clear session data
session_destroy(); // Destroy the session
header("Location: index.php"); // Redirect to the homepage after logout
exit;
?>
