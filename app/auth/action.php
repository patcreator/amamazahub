<?php
// filepath: app/auth/action.php
header('Content-Type: application/json');
session_start();

require_once '../system/cogs/db.php'; // Adjust path as needed

function jsonResponse($success, $message, $redirect = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'redirect' => $redirect
    ]);
    exit;
}

$action = $_POST['action'] ?? '';
if ($action === 'login') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        jsonResponse(false, 'Username and password are required.');
    }

    // Example: Replace with your actual user query
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? or email = ?");
    $stmt->execute([$username,$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user'] = [$user['username'], $user['email'], $user['status'], $user['created_at'], $user['updated_at']];
        $_SESSION['token'] = bin2hex(random_bytes(16));
        $_SESSION['project_id'] = '965766';
        jsonResponse(true, 'Login successful.', '../../');
    } else {
        jsonResponse(false, 'Invalid username or password.');
    }
}

if ($action === 'register') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $email === '' || $password === '') {
        jsonResponse(false, 'All fields are required.');
    }

    // Check if username or email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        jsonResponse(false, 'Username or email already exists.');
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $hashedPassword])) {
        $id = $pdo->lastInsertId();
        $add = $pdo->prepare("INSERT INTO `user_profile`(`user_id`, `first_name`, `last_name`, `username`, `email`, `phone`, `avatar_url`, `bio`, `gender`, `date_of_birth`, `country`, `city`, `state`, `zip_code`, `social_links`, `created_at`, `updated_at`) VALUES 
            (   ?,
                ?,
                '',
                ?,
                ?,
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                NULL,
                CURRENT_TIMESTAMP,
                NULL
            )");
        $add->execute([$id,$username,$username,$email]);

        jsonResponse(true, 'Registration successful.', '../../');
    } else {
        jsonResponse(false, 'Registration failed.');
    }
}

if ($action === 'forgot') {
    $email = trim($_POST['email'] ?? '');
    if ($email === '') {
        jsonResponse(false, 'Email is required.');
    }

    // Example: Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a reset token and save it (implement your own logic)
        $token = bin2hex(random_bytes(32));
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id = ?");
        $stmt->execute([$token, $user['id']]);

        // Send email (implement your own mail logic)
        // mail($email, "Password Reset", "Reset link: https://yourdomain.com/reset.php?token=$token");

        jsonResponse(true, 'Reset link sent to your email.');
    } else {
        jsonResponse(false, 'Email not found.');
    }
}

jsonResponse(false, 'Invalid action.');