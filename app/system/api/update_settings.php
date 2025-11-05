<?php
session_start();
require '../cogs/db.php'; // your PDO connection

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name   = $_POST['first_name'] ?? '';
    $last_name    = $_POST['last_name'] ?? '';
    $phone        = $_POST['phone'] ?? '';
    $avatar_url   = $_POST['avatar_url'] ?? '';
    $bio          = $_POST['bio'] ?? '';
    $social_links = $_POST['social_links'] ?? '';

    // Update password if provided
    if (!empty($_POST['password']) && $_POST['password'] === $_POST['repassword']) {
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$password_hash, $user_id]);
    }

    // Update profile
    $stmt = $pdo->prepare("UPDATE user_profile 
        SET first_name=?, last_name=?, phone=?, avatar_url=?, bio=?, social_links=? 
        WHERE user_id=?");
    $success = $stmt->execute([$first_name, $last_name, $phone, $avatar_url, $bio, $social_links, $user_id]);

    if ($success) {
        echo json_encode(['status' => 'success', 'avatar_url' => $avatar_url]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Update failed']);
    }
}
