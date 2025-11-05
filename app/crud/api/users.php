<?php
header('Content-Type: application/json');
include_once '../../system/cogs/db.php'; 


if(isset($_GET['action']) && $_GET['action']=='bulk_export' && !empty($_GET['ids'])){
    $ids = implode(',', array_map('intval', explode(',', $_GET['ids'])));
    $stmt = $pdo->query("SELECT * FROM users WHERE id IN ($ids)");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Export CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=users_export.csv');
    $output = fopen('php://output','w');
    fputcsv($output, array_keys($users[0])); // Header row
    foreach($users as $row){
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

if (isset($_GET['action']) && $_GET['action']=='export'){
            // export all users as CSV
            $stmt = $pdo->query("SELECT * FROM users");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $filename = 'users_export_'.date('Ymd_His').'.csv';
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            $out = fopen('php://output', 'w');
            fputcsv($out, array_keys($users[0]));
            foreach($users as $u) fputcsv($out, $u);
            fclose($out);
            exit;

}



$action = $_POST['action'] ?? '';
$response = ['success' => false, 'message' => 'Invalid action'];

// Helper: fetch JSON input for bulk actions
$ids = $_POST['ids'] ?? [];
if(is_string($ids)) $ids = explode(',', $ids);

// Helper: validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isNot($a = []) {
    foreach ($a as $item){
        if(!$item){
            throw new Exception("$item field are required.");
        }
    }
}


function isUnique($table, $field, $value) {
    global $pdo;

    // Basic validation to prevent SQL injection via table/field names
    $allowedChars = '/^[a-zA-Z0-9_]+$/';
    if (!preg_match($allowedChars, $table) || !preg_match($allowedChars, $field)) {
        throw new Exception("Invalid table or field name");
    }

    $sql = "SELECT COUNT(*) FROM `$table` WHERE `$field` = :value";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':value' => $value]);

    $count = $stmt->fetchColumn();

    // If count is 0, the value is unique (not found in DB)
    return $count == 0;
}

function isUniqueLoop($table, $data) {
    foreach ($data as $field => $value) {
        if (isUnique($table, $field, $value)) {
            return [
                'success' => true,
                'message' => "Field '$field' with value '$value' is unique.",
                'field'   => $field,
                'value'   => $value
            ];
        }
    }

    // If no field was unique
    return [
        'success' => false,
        'message' => "No unique fields found.",
        'field'   => null,
        'value'   => null
    ];
}


function unique_cols($table){
    global $pdo;
    // 2. Get table description
    $stmt = $pdo->query("DESCRIBE `$table`");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Extract only unique columns
    $unique_cols = [];
    foreach ($columns as $col) {
        if ($col['Key'] === 'UNI') {
            $unique_cols[] = $col['Field'];
        }
    }
    return $unique_cols;
}


function autoIsUniqueChecker($table) {
    global $pdo;

    // 1. Validate table name
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
        throw new Exception("Invalid table name.");
    }

    // 2. Get table description
    $stmt = $pdo->query("DESCRIBE `$table`");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Extract only unique columns
    $unique_cols = [];
    foreach ($columns as $col) {
        if ($col['Key'] === 'UNI') {
            $unique_cols[] = $col['Field'];
        }
    }

    // 4. Filter POST data to keep only fields that are unique in DB
    $data_to_check = [];
    foreach ($_POST as $key => $value) {
        if (in_array($key, $unique_cols, true)) {
            $data_to_check[$key] = $value;
        }
    }

    // 5. If no unique columns in POST, return early
    if (empty($data_to_check)) {
        return [
            'success' => true,
            'message' => "No unique columns found in POST data to check.",
            'field' => null,
            'value' => null
        ];
    }

    // 6. Loop through and check each unique column
    foreach ($data_to_check as $field => $value) {
        if (!isUnique($table, $field, $value)) {
            return [
                'success' => false,
                'message' => "Value '$value' for field '$field' already exists in table '$table'.",
                'field' => $field,
                'value' => $value
            ];
        }
    }

    // 7. If all unique fields pass
    return [
        'success' => true,
        'message' => "All unique fields are unique.",
        'field' => null,
        'value' => null
    ];
}




try {
    switch($action) {

        case 'insert':
            $id = trim($_POST['id'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $created_at = trim($_POST['created_at'] ?? '');
        $updated_at = trim($_POST['updated_at'] ?? '');
        $status = trim($_POST['status'] ?? '');
        
            isNot(['id', 'username', 'email', 'password', 'created_at', 'updated_at', 'status']);
            // Check if column exists
            isUnique(['id'=>$id, 'username'=>$username, 'email'=>$email, 'password'=>$password, 'created_at'=>$created_at, 'updated_at'=>$updated_at, 'status'=>$status]);
            $stmt = $pdo->prepare("INSERT INTO users (id, username, email, password, created_at, updated_at, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if($stmt->execute([$id, $username, $email, $password, $created_at, $updated_at, $status])) {
                $response = ['success'=>true, 'message'=>'users added successfully', 'id'=>$pdo->lastInsertId()];
            } else {
                throw new Exception("Failed to insert users");
            }
            break;

        case 'edit':
            $id = intval($_POST['id'] ?? 'unknow');
            $id = trim($_POST['id'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $created_at = trim($_POST['created_at'] ?? '');
        $updated_at = trim($_POST['updated_at'] ?? '');
        $status = trim($_POST['status'] ?? '');
        
            isNot(['id', 'username', 'email', 'password', 'created_at', 'updated_at', 'status']);
            isUnique(['id'=>$id, 'username'=>$username, 'email'=>$email, 'password'=>$password, 'created_at'=>$created_at, 'updated_at'=>$updated_at, 'status'=>$status]);
            $stmt = $pdo->prepare("UPDATE users SET id=?, username=?, email=?, password=?, created_at=?, updated_at=?, status=? WHERE id=?");
            if($stmt->execute([$id, $username, $email, $password, $created_at, $updated_at, $status,  $id])) {
                $response = ['success'=>true, 'message'=>'users updated successfully'];
            } else {
                throw new Exception("Failed to update users");
            }
            break;

        case 'delete':
            $id = intval($_POST['id'] ?? 'unknow');
            if($id == 'unknow') throw new Exception("Invalid ID");
            $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
            if($stmt->execute([$id])) {
                $response = ['success'=>true, 'message'=>'Data has been removed!'];
            } else {
                throw new Exception("Failed to delete data with id : $id");
            }
            break;

        case 'view':
            $id = intval($_POST['id'] ?? 'unknow');
            if($id == 'unknow') throw new Exception("Invalid ID");
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
            $stmt->execute([$id]);
            $users = $stmt->fetch(PDO::FETCH_ASSOC);
            if($users) $response = ['success'=>true, 'data'=>$users];
            else throw new Exception("users not found");
            break;

        case 'bulk_view':
            $ids = $_POST['ids']; // array of IDs
            $in  = str_repeat('?,', count($ids) - 1) . '?';
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id IN ($in)");
            $stmt->execute($ids);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success'=>true, 'data'=>$users]);
            exit;

        case 'bulk_edit':
            foreach($_POST['ids'] as $id){
                $stmt = $pdo->prepare("UPDATE users SET id=?, username=?, email=?, password=?, created_at=?, updated_at=?, status=? WHERE id=?");
                $stmt->execute([$id, $username, $email, $password, $created_at, $updated_at, $status,  $id]);
            }
            echo json_encode(['success'=>true,'message'=>'Data updated successfully']);
            exit;

        case 'copy':
            $id = intval($_POST['id'] ?? 'unknow');
            if($id == 'unknow') throw new Exception("Invalid ID");
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
            $stmt->execute([$id]);
            $users = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$users) throw new Exception("Data not found");

            $stmt = $pdo->prepare("INSERT INTO users (id, username, email, password, created_at, updated_at, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$users['email'], $users['email'], $users['email'], $users['email'], $users['email'], $users['email'], $users['email']]);
            $response = ['success'=>true, 'message'=>'new data is recorded', 'id'=>$pdo->lastInsertId()];
            break;
        case 'bulk_copy':
            if(empty($ids)) throw new Exception("No IDs provided");
            foreach($_POST['ids'] as $id){
                $id = trim($_POST['id'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $created_at = trim($_POST['created_at'] ?? '');
        $updated_at = trim($_POST['updated_at'] ?? '');
        $status = trim($_POST['status'] ?? '');
        
                isNot(['id', 'username', 'email', 'password', 'created_at', 'updated_at', 'status']);
                isUnique(['id'=>$id, 'username'=>$username, 'email'=>$email, 'password'=>$password, 'created_at'=>$created_at, 'updated_at'=>$updated_at, 'status'=>$status]);
                $stmt = $pdo->prepare("INSERT INTO users (id, username, email, password, created_at, updated_at, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$id, $username, $email, $password, $created_at, $updated_at, $status]);
            }
            $response = ['success'=>true,'message'=>'data copied successfully'];
            break;
        case 'bulk_delete':
            if(empty($ids)) throw new Exception("No IDs provided");
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $pdo->prepare("DELETE FROM users WHERE id IN ($placeholders)");
            $stmt->execute($ids);
            $response = ['success'=>true, 'message'=>count($ids).' users deleted'];
            break;

        case 'copy_many':
            if(empty($ids)) throw new Exception("No IDs provided");
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id IN (".implode(',', array_fill(0,count($ids),'?')).")");
            $stmt->execute($ids);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($users as $u){
                $stmt2 = $pdo->prepare("INSERT INTO users (id, username, email, password, created_at, updated_at, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt2->execute([$u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email']]);
            }
            $response = ['success'=>true, 'message'=>count($users).' data copied (registed)'];
            break;
            case 'import':
                    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                        http_response_code(400);
                        echo 'File upload failed.';
                        exit;
                    }

                    $file = $_FILES['file'];
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                    if (!in_array($ext, ['csv', 'sql'])) {
                        http_response_code(400);
                        echo 'Invalid file type. Only CSV and SQL files are allowed.';
                        exit;
                    }

                    // Save file to temporary location (you can change this path)
                    $uploadDir = '../../system/filemanager/imports/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                    $destination = $uploadDir . basename($file['name']);
                    if (move_uploaded_file($file['tmp_name'], $destination)) {
                        $response = ['success'=>true, 'message'=>'File uploaded successfully: ' . htmlspecialchars($file['name'])];
                    // =========================
                    // Handle SQL file
                    // =========================
                    if ($ext === 'sql') {
                        try {
                            $sql = file_get_contents($destination);
                            $pdo->exec($sql);
                            $response = ['success'=>false, 'message'=>'SQL file imported successfully.'];
                        } catch (PDOException $e) {
                            http_response_code(500);
                            $response = ['success'=>false, 'message'=>'SQL import error: ' . $e->getMessage()];
                        }
                        exit;
                    }

                    // =========================
                    //  Handle CSV file
                    // =========================
                    if ($ext === 'csv') {
                        $handle = fopen($destination, 'r');
                        if ($handle === false) {
                            http_response_code(500);
                            $response = ['success'=>false, 'message'=>'Could not open CSV file.'];
                            exit;
                        }

                        $headers = fgetcsv($handle); // First row: column headers
                        if (!$headers) {
                            http_response_code(400);
                            $response = ['success'=>false, 'message'=>'Invalid CSV format, first row must be header.'];
                            exit;
                        }

                        // Prepare insert query dynamically based on headers
                        $placeholders = implode(', ', array_fill(0, count($headers), '?'));
                        $columns = implode(', ', array_map(fn($h) => "`" . trim($h) . "`", $headers));
                        $stmt = $pdo->prepare("INSERT INTO users ($columns) VALUES ($placeholders)");

                        $rowCount = 0;
                        while (($row = fgetcsv($handle)) !== false) {
                            // Skip empty rows
                            if (count(array_filter($row)) === 0) continue;

                            try {
                                $stmt->execute($row);
                                $rowCount++;
                            } catch (PDOException $e) {
                                $response = ['success'=>false, 'message'=>"To import please your file  must be sql(insert) or csv(first row is header). "];
                            }
                        }

                    } else {
                        http_response_code(500);
                        $response = ['success'=>false, 'message'=>'Failed to move uploaded file.'];
                    }
                }

            break;
        case 'update_many':
            if(empty($ids)) throw new Exception("No IDs provided");
            $id = trim($_POST['id'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $created_at = trim($_POST['created_at'] ?? '');
        $updated_at = trim($_POST['updated_at'] ?? '');
        $status = trim($_POST['status'] ?? '');
        
            if(!$status) throw new Exception("all field with * is required.");
            $stmt = $pdo->prepare("UPDATE users SET id=?, username=?, email=?, password=?, created_at=?, updated_at=?, status=? WHERE id IN (".implode(',', array_fill(0,count($ids),'?')).")");
            $stmt->execute(array_merge([$id, $username, $email, $password, $created_at, $updated_at, $status, ], $ids));
            $response = ['success'=>true, 'message'=>count($ids).' data updated in users'];
            break;
        case 'inline_update':
            $id = intval($_POST['id']);
            $field = $_POST['field'];
            $value = $_POST['value'];

            $allowed_fields = ['id', 'username', 'email', 'password', 'created_at', 'updated_at', 'status'];
            if (!in_array($field, $allowed_fields)) {
                echo json_encode(['success' => false, 'message' => 'Invalid field']);
                exit;
            }

            $unique = isUniqueLoop('users',[$field=>$value]);

            $unique_cols = unique_cols('users'); 
            if (in_array($field, $unique_cols)) {
                $unique = isUnique($table, $field, $value);
            }else{
                $unique = false;
            }

            if ($unique) {
                echo json_encode(['message' => $field." exists",'success' => false]);
                exit;
            }else{
                $stmt = $pdo->prepare("UPDATE users SET `$field` = :value WHERE id = :id");
                $success = $stmt->execute(['value' => $value, 'id' => $id]);
                echo json_encode(['message' => 'Data updated','success' => $success]);
                
               exit;
            }
            
        default:
            throw new Exception("Unknown action");

    }

} catch(Exception $e){
    $response = ['success'=>false, 'message'=>$e->getMessage()];
}

echo json_encode($response);
?>