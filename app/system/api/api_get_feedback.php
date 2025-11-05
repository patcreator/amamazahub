<?php
header('Content-Type: application/json');
include_once '../cogs/db.php';
// Optional filter by status
$status = $_GET['status'] ?? null;

$sql = "SELECT * FROM feedback";
$params = [];

if ($status) {
    $sql .= " WHERE status = :status";
    $params[':status'] = $status;
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$feedback = $stmt->fetchAll();

echo json_encode(['success' => true, 'feedback' => $feedback]);
