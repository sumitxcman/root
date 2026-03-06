<?php
echo "Current File: " . __FILE__ . "<br>";
echo "Current Folder: " . __DIR__ . "<br>";

$userAddPath = __DIR__ . '/user/add.php';

if (file_exists($userAddPath)) {
    echo " Success: 'user/add.php' ";
} else {
    echo " Error: 'user/add.php';
}
?>