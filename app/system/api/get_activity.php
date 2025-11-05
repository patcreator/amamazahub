<?php
require_once '../cogs/db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT activity_type, description, ip_address, created_at 
                           FROM user_activity 
                           WHERE user_id = ? 
                           ORDER BY created_at DESC 
                           LIMIT 20");
    $stmt->execute([$user_id]);
    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'activities' => $activities]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch activities.']);
}
