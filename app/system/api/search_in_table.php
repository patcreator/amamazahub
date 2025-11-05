<?php
header('Content-Type: application/json');
include '../cogs/db.php';
// --- Handle AJAX request for search suggestions ---
if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['table'] ?? '');
    $column = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['column'] ?? '');
    $search = $_GET['q'] ?? '';
    $results = [];

    if ($table && $column && $search) {
        $sql = "SELECT * FROM `$table` WHERE `$column` LIKE :s ORDER BY created_at DESC LIMIT 10";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['s' => "%$search%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    header('Content-Type: application/json');
    echo json_encode($results);
    exit;
}
?>
