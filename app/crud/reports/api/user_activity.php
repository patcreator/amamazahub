<?php
// Auto-generated report API for table: user_activity

require_once '../../../system/cogs/db.php';
// Handle AJAX request
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');

    $query = $_GET['query'] ?? '';
    $status = $_GET['status'] ?? '';
    $sort = $_GET['sort'] ?? '';
    $dir = $_GET['dir'] ?? 'DESC';

    $sql = "SELECT `id`, `user_id`, `activity_type`, `description`, `ip_address`, `created_at`, `updated_at`, `status` FROM `user_activity` WHERE 1";
    $params = [];
    if ($query) {
        $likeParts = [];
        $likeParts[] = "activity_type LIKE ?";
        $likeParts[] = "description LIKE ?";
        $likeParts[] = "ip_address LIKE ?";
        $sql .= " AND (" . implode(' OR ', $likeParts) . ")";
        foreach ($likeParts as $lp) { $params[] = "%$query%"; }
    }
    if ($status) {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    $allowedSort = ['id','user_id','created_at','updated_at'];
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