<?php
header('Content-Type: application/json');

include_once "../cogs/db.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $pdo->query("SELECT * FROM todos ORDER BY created_at DESC");
    $todos = $stmt->fetchAll();
    echo json_encode($todos);

} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO todos (task) VALUES (:task)");
    $stmt->execute(['task' => $data['task']]);
    echo json_encode(["success" => true]);

} elseif ($method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("UPDATE todos SET completed = :completed WHERE id = :id");
    $stmt->execute([
        'completed' => $data['completed'] ? 1 : 0,
        'id' => $data['id']
    ]);
    echo json_encode(["success" => true]);

} elseif ($method === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = :id");
    $stmt->execute(['id' => $data['id']]);
    echo json_encode(["success" => true]);
}
