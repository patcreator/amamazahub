<?php

// AJAX handler
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    include_once '../cogs/db.php';
    $query = $_GET['query'] ?? '';
    $status = $_GET['status'] ?? '';
    $sort = $_GET['sort'] ?? 'created_at';
    $dir = $_GET['dir'] ?? 'DESC';

    $sql = "SELECT id, username, email, created_at, updated_at, status FROM users";
    $params = [];

    if ($query) {
        $sql .= " AND (username LIKE ? OR email LIKE ?)";
        $params = ["%$query%", "%$query%"];
    }
    if ($status) {
        $sql .= " AND status = ?";
        $params[] = $status;
    }

    $allowedSort = ['created_at', 'updated_at', 'username'];
    if (!in_array($sort, $allowedSort)) $sort = 'created_at';
    $dir = strtoupper($dir) === 'ASC' ? 'ASC' : 'DESC';

    $sql .= " ORDER BY $sort $dir";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // For chart: add month
    foreach ($users as &$u) {
        $month = date('M Y', strtotime($u['created_at']));
        $u['signup_month'] = $month;
    }

    echo json_encode($users);
    exit;
}
?>