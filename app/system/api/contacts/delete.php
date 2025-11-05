<?php
header('Content-Type: application/json');
require '../../cogs/db.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing ID"]);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
$stmt->execute([$data['id']]);

echo json_encode(["success" => true]);
?>
