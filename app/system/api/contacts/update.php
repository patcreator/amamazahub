<?php
header('Content-Type: application/json');
require '../../cogs/db.php';
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id'], $data['name'], $data['phone'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing fields"]);
    exit;
}

$stmt = $pdo->prepare("UPDATE contacts SET name = ?, phone = ?, email = ? WHERE id = ?");
$stmt->execute([$data['name'], $data['phone'], $data['email'] ?? null, $data['id']]);

echo json_encode(["success" => true]);
?>
