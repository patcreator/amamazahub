<?php
header('Content-Type: application/json');
require_once '../system/cogs/db.php';

$response = ['success' => false, 'message' => 'Invalid request'];

try {
    // === GET TABLE & ACTION ===
    $table = $_POST['table'] ?? $_GET['table'] ?? null;
    $action = strtolower($_POST['action'] ?? $_GET['action'] ?? '');

    if (!$table || !$action) {
        echo json_encode(['success' => false, 'message' => 'Missing table or action']);
        exit;
    }

    // === GET COLUMNS FOR TABLE ===
    $colsStmt = $pdo->prepare("SHOW COLUMNS FROM `$table`");
    $colsStmt->execute();
    $columns = $colsStmt->fetchAll(PDO::FETCH_COLUMN);

    if (!$columns) {
        echo json_encode(['success' => false, 'message' => 'Table not found']);
        exit;
    }

    // === GET PRIMARY KEY ===
    $primaryKey = null;
    $descStmt = $pdo->prepare("SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'");
    $descStmt->execute();
    $pkRow = $descStmt->fetch(PDO::FETCH_ASSOC);
    if ($pkRow) $primaryKey = $pkRow['Column_name'];

    // === HELPER: UPLOAD FILES ===
    function handleFileUploads($files)
    {
        $uploads = [];
        foreach ($files as $field => $fileInfo) {
            if (is_array($fileInfo['name'])) {
                // Multiple file uploads
                $uploads[$field] = [];
                for ($i = 0; $i < count($fileInfo['name']); $i++) {
                    if ($fileInfo['error'][$i] === UPLOAD_ERR_OK) {
                        $tmp = $fileInfo['tmp_name'][$i];
                        $name = uniqid() . "_" . basename($fileInfo['name'][$i]);
                        $path = "uploads/" . $name;
                        if (!is_dir("uploads")) mkdir("uploads", 0777, true);
                        move_uploaded_file($tmp, $path);
                        $uploads[$field][] = $path;
                    }
                }
            } else {
                if ($fileInfo['error'] === UPLOAD_ERR_OK) {
                    $tmp = $fileInfo['tmp_name'];
                    $name = uniqid() . "_" . basename($fileInfo['name']);
                    $path = "uploads/" . $name;
                    if (!is_dir("uploads")) mkdir("uploads", 0777, true);
                    move_uploaded_file($tmp, $path);
                    $uploads[$field] = $path;
                }
            }
        }
        return $uploads;
    }

    // === CLEAN INPUTS ===
    $inputData = [];
    foreach ($_POST as $key => $value) {
        if (in_array($key, ['table', 'action'])) continue;
        $inputData[$key] = is_array($value)
            ? implode(',', array_map('trim', $value))
            : trim($value);
    }

    // === ADD FILES ===
    if (!empty($_FILES)) {
        $uploaded = handleFileUploads($_FILES);
        foreach ($uploaded as $field => $path) {
            $inputData[$field] = is_array($path) ? json_encode($path) : $path;
        }
    }

    // === FUNCTION: CHECK UNIQUE COLUMNS ===
    function checkUniqueColumns($pdo, $table, $inputData, $primaryKey = null, $currentId = null)
    {
        // Get all unique keys
        $uniqueStmt = $pdo->prepare("SHOW KEYS FROM `$table` WHERE Non_unique = 0");
        $uniqueStmt->execute();
        $uniqueKeys = $uniqueStmt->fetchAll(PDO::FETCH_ASSOC);

        $uniqueCols = array_unique(array_column($uniqueKeys, 'Column_name'));

        foreach ($uniqueCols as $col) {
            if (!isset($inputData[$col])) continue;
            $value = $inputData[$col];

            // Build SQL to check duplicates
            $sql = "SELECT COUNT(*) FROM `$table` WHERE `$col` = :val";
            $params = [':val' => $value];

            // Exclude current record on update
            if ($primaryKey && $currentId) {
                $sql .= " AND `$primaryKey` != :pk";
                $params[':pk'] = $currentId;
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $count = $stmt->fetchColumn();
            $col = str_replace('_', ' ', $col);
            if ($count > 0) {
                throw new Exception("$col already exists.");
            }
        }
    }

    // === ACTION HANDLER ===
    switch ($action) {
        case 'insert':
            // Check uniqueness before inserting
            checkUniqueColumns($pdo, $table, $inputData, $primaryKey);

            $insertCols = [];
            $insertVals = [];
            $insertParams = [];

            foreach ($inputData as $col => $val) {
                if (in_array($col, $columns)) {
                    $insertCols[] = "`$col`";
                    $insertVals[] = ":$col";
                    $insertParams[":$col"] = $val;
                }
            }

            if (empty($insertCols)) {
                throw new Exception("No valid columns found for insert.");
            }

            $sql = "INSERT INTO `$table` (" . implode(",", $insertCols) . ") VALUES (" . implode(",", $insertVals) . ")";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($insertParams);
            $response = ['success' => true, 'message' =>ucfirst($table) . ' data registed'];
            break;

        case 'update':
            if (!$primaryKey || !isset($inputData[$primaryKey])) {
                throw new Exception("Missing primary key for update.");
            }

            // Check uniqueness before updating
            checkUniqueColumns($pdo, $table, $inputData, $primaryKey, $inputData[$primaryKey]);

            $setParts = [];
            $params = [];
            foreach ($inputData as $col => $val) {
                if (in_array($col, $columns) && $col !== $primaryKey) {
                    $setParts[] = "`$col` = :$col";
                    $params[":$col"] = $val;
                }
            }
            $params[":pk"] = $inputData[$primaryKey];

            if (empty($setParts)) {
                throw new Exception("No valid columns to update.");
            }

            $sql = "UPDATE `$table` SET " . implode(",", $setParts) . " WHERE `$primaryKey` = :pk";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $response = ['success' => true, 'message' => 'Record updated successfully.'];
            break;

        case 'delete':
            $id = $_POST[$primaryKey] ?? $_GET[$primaryKey] ?? null;
            if (!$primaryKey || !$id) {
                throw new Exception("Missing primary key for delete.");
            }

            $sql = "DELETE FROM `$table` WHERE `$primaryKey` = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $response = ['success' => true, 'message' => 'Record deleted successfully.'];
            break;

        case 'select':
            $id = $_POST[$primaryKey] ?? $_GET[$primaryKey] ?? null;
            if ($id) {
                $sql = "SELECT * FROM `$table` WHERE `$primaryKey` = :id LIMIT 1";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $id]);
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $response = ['success' => true, 'data' => $data ?: [], 'message' => 'Record fetched'];
            } else {
                $sql = "SELECT * FROM `$table`";
                $stmt = $pdo->query($sql);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $response = ['success' => true, 'data' => $data, 'message' => 'All records fetched'];
            }
            break;

        default:
            throw new Exception("Invalid action specified.");
    }

} catch (PDOException $e) {
    $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

echo json_encode($response);
exit;
?>
