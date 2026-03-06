<?php
require '../../include/load.php';
checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // SQL function: Agar key hai toh update karo, nahi toh insert
    function updateKey($key, $value, $pdo) {
        $sql = "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE setting_value = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$key, $value, $value]);
    }

    // 1. Text fields save karna
    updateKey('site_title', $_POST['site_title'], $pdo);
    updateKey('contact_email', $_POST['contact_email'], $pdo);
    updateKey('footer_text', $_POST['footer_text'], $pdo);

    // 2. Logo upload handle karna
    if (!empty($_FILES['site_logo']['name'])) {
        $targetDir = "../../assets/uploads/";
        
        // Folder check karna
        if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }

        $fileName = "logo_" . time() . ".png"; // Unique name
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $targetFile)) {
            updateKey('site_logo', $fileName, $pdo);
        }
    }

    // Wapas settings page par bhej dena
    header("Location: ../../settings/index.php?success=1");
    exit();
}