<?php

$_SESSION['id'] = [];
// Unset all of the session variables
unset($_SESSION['id']);

// Destroy the session.
session_destroy();

// Redirect to login page
header("Location: index.php?action=login");
exit;
?>
