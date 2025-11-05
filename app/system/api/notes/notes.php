<?php
header('Content-Type: application/json; charset=utf-8');
require '../../cogs/db.php';

// read raw JSON
$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? $_POST['action'] ?? null;

if (!$action) {
    echo json_encode(['error' => 'No action']);
    exit;
}

try {
    if ($action === 'list') {
        $stmt = $pdo->query("SELECT id, title, content, updated_at FROM notes ORDER BY updated_at DESC");
        $rows = $stmt->fetchAll();
        echo json_encode($rows);
        exit;
    }

    if ($action === 'get') {
        $id = (int)($input['id'] ?? 0);
        if (!$id) { echo json_encode(['error'=>'Missing id']); exit; }
        $stmt = $pdo->prepare("SELECT id, title, content, updated_at FROM notes WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        echo json_encode($row ?: null);
        exit;
    }

    if ($action === 'create') {
        $title = $input['title'] ?? 'Untitled';
        $content = $input['content'] ?? '';
        $stmt = $pdo->prepare("INSERT INTO notes (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
        exit;
    }

    if ($action === 'update') {
        $id = (int)($input['id'] ?? 0);
        if (!$id) { echo json_encode(['error'=>'Missing id']); exit; }
        $title = $input['title'] ?? '';
        $content = $input['content'] ?? '';
        $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$title, $content, $id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'delete') {
        $id = (int)($input['id'] ?? 0);
        if (!$id) { echo json_encode(['error'=>'Missing id']); exit; }
        $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        exit;
    }

    echo json_encode(['error' => 'Unknown action']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
