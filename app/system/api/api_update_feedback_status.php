<?php
header('Content-Type: application/json');

include_once '../cogs/db.php';

// Get POST data
$id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;

$valid_statuses = ['new', 'in_review', 'resolved', 'closed'];

if (!$id || !in_array($status, $valid_statuses)) {
    echo json_encode(['success' => false, 'message' => 'Invalid ID or status']);
    exit;
}

$sql = "UPDATE feedback SET status = :status WHERE id = :id";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([':status' => $status, ':id' => $id]);
    echo json_encode(['success' => true, 'message' => 'Status updated']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to update status']);
}
