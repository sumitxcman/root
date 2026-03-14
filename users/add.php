<?php
require 'include/load.php';


$first_names = ['Ali', 'Ahmed', 'Sara', 'Zain', 'Hamza', 'Danish', 'Fatima', 'Bilal', 'Sana', 'Usman'];
$last_names = ['Khan', 'Sheikh', 'Malik', 'Raza', 'Ahmed', 'Hassan', 'Javed', 'Abbasi', 'Mughal', 'Iqbal'];

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    
    echo "<h2>Users Adding Progress:</h2><ul>";
    
    for ($i = 1; $i <= 20; $i++) {
        $f = $first_names[array_rand($first_names)];
        $l = $last_names[array_rand($last_names)];
        
        $username = strtolower($f . "_" . $l . $i);
        $email = $username . "@example.com";
        $password = password_hash('password123', PASSWORD_DEFAULT); 
        $role = ($i == 1) ? 'admin' : 'user'; 
        
        $stmt->execute([$username, $email, $password, $role]);
        
        echo "<li>User $i: <b>$username</b> added!</li>";
    }
    
    echo "</ul><h3 style='color: green;'>Mubarak ho! 20 Users kamyabi se add ho gaye hain.</h3>";
    echo "<a href='dashboard.php' style='padding:10px; background:blue; color:white; text-decoration:none;'>Dashboard Check Karein</a>";

} catch (PDOException $e) {
    echo "<h3 style='color: red;'>Error: " . $e->getMessage() . "</h3>";
}
?>