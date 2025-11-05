<?php
include_once '../cogs/db.php';

// Get parameters from DataTables
$draw = $_GET['draw'] ?? 1;
$start = $_GET['start'] ?? 0;
$length = $_GET['length'] ?? 10;
$searchValue = $_GET['search']['value'] ?? '';
$orderColumn = $_GET['order'][0]['column'] ?? 0;
$orderDir = $_GET['order'][0]['dir'] ?? 'asc';

// Map column index to database column
$columns = ['id','user_id','action','entity_type','entity_id','old_value','new_value','ip_address','user_agent','created_at'];
$orderColumn = $columns[$orderColumn] ?? 'id';

// Count total records
$totalQuery = $pdo->query("SELECT COUNT(*) as total FROM history");
$totalRecords = $totalQuery->fetch()['total'];

// Base query
$sql = "SELECT * FROM history WHERE 1=1 ";
$params = [];

// Apply search
if($searchValue) {
    $sql .= " AND (user_id LIKE :search OR action LIKE :search OR entity_type LIKE :search OR entity_id LIKE :search OR old_value LIKE :search OR new_value LIKE :search OR ip_address LIKE :search OR user_agent LIKE :search) ";
    $params[':search'] = "%$searchValue%";
}

// Count filtered records
$countStmt = $pdo->prepare(str_replace('*', 'COUNT(*)', $sql));
$countStmt->execute($params);
$filteredRecords = $countStmt->fetchColumn();

// Add ordering and limit
$sql .= " ORDER BY $orderColumn $orderDir LIMIT :start, :length";
$stmt = $pdo->prepare($sql);

// Bind search
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}

// Bind limit/offset (safe integers)
$stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
$stmt->bindValue(':length', (int)$length, PDO::PARAM_INT);

$stmt->execute();
$data = $stmt->fetchAll();

// Format data for DataTables
$response = [
    "draw" => (int)$draw,
    "recordsTotal" => (int)$totalRecords,
    "recordsFiltered" => (int)$filteredRecords,
    "data" => []
];

foreach ($data as $row) {
    $response['data'][] = [
        $row['id'],
        $row['user_id'],
        $row['action'],
        $row['entity_type'],
        $row['entity_id'],
        $row['old_value'],
        $row['new_value'],
        $row['ip_address'],
        $row['user_agent'],
        $row['created_at']
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
