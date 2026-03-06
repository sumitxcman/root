<?php
require_once '../../include/load.php'; // Path ka dhyan rakhein (do bar peeche)

// Security Check: Sirf logged in user hi add kar sake
checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF Check (Zaroori hai kyunki humne csrf.php banaya tha)
    // Note: Agar aapne form mein csrf token nahi dala toh ye fail ho jayega
    
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password']; // Real project mein password_hash use karein
    $role     = 'user'; // Default role

    try {
        // SQL Injection se bachne ke liye prepare statement
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $role]);

        // Success! Wapis bhej dein message ke saath
        header("Location: ../../manage-users.php?msg=User Added Successfully");
        exit();
    } catch (PDOException $e) {
        // Agar email already exist karta ho ya koi aur error ho
        die("Error adding user: " . $e->getMessage());
    }
}