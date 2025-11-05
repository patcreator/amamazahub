<?php
include_once '../cogs/db.php';
// Handle AJAX requests
if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    $action = $_GET['action'];

    if ($action === 'list') {
        $stmt = $pdo->query("SELECT * FROM help_topics ORDER BY updated_at DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    if ($action === 'add') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $stmt = $pdo->prepare("INSERT INTO help_topics (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);
        echo json_encode(['success'=>true]);
        exit;
    }

    if ($action === 'update') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $stmt = $pdo->prepare("UPDATE help_topics SET title=?, content=? WHERE id=?");
        $stmt->execute([$title, $content, $id]);
        echo json_encode(['success'=>true]);
        exit;
    }

    if ($action === 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM help_topics WHERE id=?");
        $stmt->execute([$id]);
        echo json_encode(['success'=>true,'message'=>'Data deleted']);
        exit;
    }
}else{
    echo json_encode(['success'=>false,'message'=>'Action is required']);
}
?>
