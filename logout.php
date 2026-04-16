<?php
session_start();
session_unset();
session_destroy();

// Redirecting to Sign In page as per your screenshot
header("Location: sign-in.php"); 
exit;
?>