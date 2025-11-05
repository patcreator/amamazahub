<?php
header('Content-Type: application/json');
require '../../cogs/db.php';
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['name'], $data['phone'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing fields"]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO contacts (name, phone, email) VALUES (?, ?, ?)");
$stmt->execute([$data['name'], $data['phone'], $data['email'] ?? null]);

echo json_encode(["success" => true, "id" => $pdo->lastInsertId()]);
?>
