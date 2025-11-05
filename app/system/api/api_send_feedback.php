<?php
header('Content-Type: application/json');
include_once '../cogs/db.php';

// Get POST data
$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$subject = $_POST['subject'] ?? null;
$type = $_POST['type'] ?? 'general';
$message = $_POST['message'] ?? null;
$rating = $_POST['rating'] ?? null;

if (!$message) {
    echo json_encode(['success' => false, 'message' => 'Message is required']);
    exit;
}

// Insert feedback
$sql = "INSERT INTO feedback (name, email, subject, message, type, rating) 
        VALUES (:name, :email, :subject, :message, :type, :rating)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':subject' => $subject,
        ':message' => $message,
        ':type' => $type,
        ':rating' => $rating
    ]);
    echo json_encode(['success' => true, 'message' => 'Feedback sent successfully!']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to send feedback']);
}
