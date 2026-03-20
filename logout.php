


<?php
require_once 'include/load.php';
$_SESSION = [];
session_destroy();

// Ab redirect 'sign-up.php' par hoga
header("Location: sign-up.php"); 
exit;
?>