<?php
// Start session for user authentication
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to dashboard
    header("Location: dashboard.php");
    exit;
} else {
    // Check if user has a remember-me cookie
    if (isset($_COOKIE['remember_token'])) {
        // Validate remember-me token against database
        require_once('includes/db_connect.php');
        $token = $_COOKIE['remember_token'];
        
        // Sample token validation (replace with your actual validation logic)
        $stmt = $pdo->prepare("SELECT user_id FROM user_tokens WHERE token = ? AND expires_at > NOW()");
        $stmt->execute([$token]);
        
        if ($row = $stmt->fetch()) {
            // Valid token, set session and redirect to dashboard
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: dashboard.php");
            exit;
        }
    }
    
    // No valid session or token, redirect to login page
    header("Location: login.php");
    exit;
}
?>