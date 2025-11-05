<?php
header('Content-Type: application/json');

// Load structure
$structureFile = '../structure.json';
if (!file_exists($structureFile)) {
    echo json_encode(['status' => 'error', 'message' => 'Structure file not found']);
    exit;
}
$tables = json_decode(file_get_contents($structureFile), true);

// Get table name from POST
$table = $_POST['table'] ?? null;
if (!$table || !isset($tables[$table])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid table']);
    exit;
}

// Get table columns
$columns = $tables[$table]['columns'];

// Prepare data for insert
$data = [];
foreach ($columns as $col) {
    $colName = $col['name'];
    // Skip primary key if empty (auto-increment)
    if (!empty($col['primary_key']) && empty($_POST[$colName])) continue;

    // Sanitize input (basic example, adjust for your DB)
    $data[$colName] = htmlspecialchars($_POST[$colName] ?? $col['default']);
}

// Here you would insert $data into your database
// Example using PDO (adjust connection details)
try {
    include_once '../../cogs/db.php';
    $fields = implode(", ", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));
    $stmt = $pdo->prepare("INSERT INTO $table ($fields) VALUES ($placeholders)");
    $stmt->execute($data);

    echo json_encode(['success' => 1, 'message' => 'Data saved successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => 0, 'message' => $e->getMessage()]);
}
