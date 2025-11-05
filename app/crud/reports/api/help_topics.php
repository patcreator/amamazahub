<?php
// Auto-generated report API for table: help_topics

require_once '../../../system/cogs/db.php';
// Handle AJAX request
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');

    $query = $_GET['query'] ?? '';
    $status = $_GET['status'] ?? '';
    $sort = $_GET['sort'] ?? '';
    $dir = $_GET['dir'] ?? 'DESC';

    $sql = "SELECT `id`, `title`, `content`, `created_at`, `updated_at`, `status` FROM `help_topics` WHERE 1";
    $params = [];
    if ($query) {
        $likeParts = [];
        $likeParts[] = "title LIKE ?";
        $likeParts[] = "content LIKE ?";
        $sql .= " AND (" . implode(' OR ', $likeParts) . ")";
        foreach ($likeParts as $lp) { $params[] = "%$query%"; }
    }
    if ($status) {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    $allowedSort = ['id','created_at','updated_at'];
    if (!in_array($sort, $allowedSort)) {
        $sort = $allowedSort[0];
    }
    $dir = strtoupper($dir) === 'ASC' ? 'ASC' : 'DESC';
    $sql .= " ORDER BY $sort $dir";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Optional: Add created_month if created_at exists
    if (in_array('created_at', array_keys($rows[0] ?? []))) {
        foreach ($rows as &$r) {
            $r['created_month'] = date('M Y', strtotime($r['created_at']));
        }
    }

    echo json_encode($rows);
    exit;
}
?>