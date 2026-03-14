<?php
require_once '../../include/load.php';


checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password']; 
    $role     = 'user'; 

    try {
        
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $role]);

        
        header("Location: ../../manage-users.php?msg=User Added Successfully");
        exit();
    } catch (PDOException $e) {
       
        die("Error adding user: " . $e->getMessage());
    }
}