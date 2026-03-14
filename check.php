<?php
echo "<h3>Path Testing</h3>";
echo "Main Folder: " . __DIR__ . "<br>";

$path_to_add = __DIR__ . '/user/add.php';

if (file_exists($path_to_add)) {
    echo "<b style='color:green;'> File mil gayi!</b> ";
} else {
    echo "<b style='color:red;'> ";
    
    
    if (file_exists(__DIR__ . '/add.php')) {
        echo "<br> ";
    }
}
?>