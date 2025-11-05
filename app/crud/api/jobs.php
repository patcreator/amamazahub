<?php
header('Content-Type: application/json');
include_once '../../system/cogs/db.php'; 


if(isset($_GET['action']) && $_GET['action']=='bulk_export' && !empty($_GET['ids'])){
    $ids = implode(',', array_map('intval', explode(',', $_GET['ids'])));
    $stmt = $pdo->query("SELECT * FROM jobs WHERE  IN ($ids)");
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Export CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=jobs_export.csv');
    $output = fopen('php://output','w');
    fputcsv($output, array_keys($jobs[0])); // Header row
    foreach($jobs as $row){
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

if (isset($_GET['action']) && $_GET['action']=='export'){
            // export all jobs as CSV
            $stmt = $pdo->query("SELECT * FROM jobs");
            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $filename = 'jobs_export_'.date('Ymd_His').'.csv';
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            $out = fopen('php://output', 'w');
            fputcsv($out, array_keys($jobs[0]));
            foreach($jobs as $u) fputcsv($out, $u);
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
        $job_media = trim($_POST['job_media'] ?? '');
        $job_title = trim($_POST['job_title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $job_description = trim($_POST['job_description'] ?? '');
        $job_deadline = trim($_POST['job_deadline'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $job_category = trim($_POST['job_category'] ?? '');
        $job_media_type = trim($_POST['job_media_type'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $requirements = trim($_POST['requirements'] ?? '');
        $salary_min = trim($_POST['salary_min'] ?? '');
        $salary_max = trim($_POST['salary_max'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $employment_type = trim($_POST['employment_type'] ?? '');
        $experience_level = trim($_POST['experience_level'] ?? '');
        $remote_option = trim($_POST['remote_option'] ?? '');
        $visa_sponsorship = trim($_POST['visa_sponsorship'] ?? '');
        $relocation_assistance = trim($_POST['relocation_assistance'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $created_at = trim($_POST['created_at'] ?? '');
        $updated_at = trim($_POST['updated_at'] ?? '');
        $company_id = trim($_POST['company_id'] ?? '');
        
            isNot(['id', 'job_media', 'job_title', 'slug', 'job_description', 'job_deadline', 'company', 'job_category', 'job_media_type', 'title', 'description', 'requirements', 'salary_min', 'salary_max', 'location', 'employment_type', 'experience_level', 'remote_option', 'visa_sponsorship', 'relocation_assistance', 'status', 'created_at', 'updated_at', 'company_id']);
            // Check if column exists
            
            $stmt = $pdo->prepare("INSERT INTO jobs (id, job_media, job_title, slug, job_description, job_deadline, company, job_category, job_media_type, title, description, requirements, salary_min, salary_max, location, employment_type, experience_level, remote_option, visa_sponsorship, relocation_assistance, status, created_at, updated_at, company_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if($stmt->execute([$id, $job_media, $job_title, $slug, $job_description, $job_deadline, $company, $job_category, $job_media_type, $title, $description, $requirements, $salary_min, $salary_max, $location, $employment_type, $experience_level, $remote_option, $visa_sponsorship, $relocation_assistance, $status, $created_at, $updated_at, $company_id])) {
                $response = ['success'=>true, 'message'=>'jobs added successfully', 'id'=>$pdo->lastInsertId()];
            } else {
                throw new Exception("Failed to insert jobs");
            }
            break;

        case 'edit':
            $id = intval($_POST['id'] ?? 'unknow');
            $id = trim($_POST['id'] ?? '');
        $job_media = trim($_POST['job_media'] ?? '');
        $job_title = trim($_POST['job_title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $job_description = trim($_POST['job_description'] ?? '');
        $job_deadline = trim($_POST['job_deadline'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $job_category = trim($_POST['job_category'] ?? '');
        $job_media_type = trim($_POST['job_media_type'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $requirements = trim($_POST['requirements'] ?? '');
        $salary_min = trim($_POST['salary_min'] ?? '');
        $salary_max = trim($_POST['salary_max'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $employment_type = trim($_POST['employment_type'] ?? '');
        $experience_level = trim($_POST['experience_level'] ?? '');
        $remote_option = trim($_POST['remote_option'] ?? '');
        $visa_sponsorship = trim($_POST['visa_sponsorship'] ?? '');
        $relocation_assistance = trim($_POST['relocation_assistance'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $created_at = trim($_POST['created_at'] ?? '');
        $updated_at = trim($_POST['updated_at'] ?? '');
        $company_id = trim($_POST['company_id'] ?? '');
        
            isNot(['id', 'job_media', 'job_title', 'slug', 'job_description', 'job_deadline', 'company', 'job_category', 'job_media_type', 'title', 'description', 'requirements', 'salary_min', 'salary_max', 'location', 'employment_type', 'experience_level', 'remote_option', 'visa_sponsorship', 'relocation_assistance', 'status', 'created_at', 'updated_at', 'company_id']);
            
            $stmt = $pdo->prepare("UPDATE jobs SET id=?, job_media=?, job_title=?, slug=?, job_description=?, job_deadline=?, company=?, job_category=?, job_media_type=?, title=?, description=?, requirements=?, salary_min=?, salary_max=?, location=?, employment_type=?, experience_level=?, remote_option=?, visa_sponsorship=?, relocation_assistance=?, status=?, created_at=?, updated_at=?, company_id=? WHERE =?");
            if($stmt->execute([$id, $job_media, $job_title, $slug, $job_description, $job_deadline, $company, $job_category, $job_media_type, $title, $description, $requirements, $salary_min, $salary_max, $location, $employment_type, $experience_level, $remote_option, $visa_sponsorship, $relocation_assistance, $status, $created_at, $updated_at, $company_id,  $id])) {
                $response = ['success'=>true, 'message'=>'jobs updated successfully'];
            } else {
                throw new Exception("Failed to update jobs");
            }
            break;

        case 'delete':
            $id = intval($_POST['id'] ?? 'unknow');
            if($id == 'unknow') throw new Exception("Invalid ID");
            $stmt = $pdo->prepare("DELETE FROM jobs WHERE =?");
            if($stmt->execute([$id])) {
                $response = ['success'=>true, 'message'=>'Data has been removed!'];
            } else {
                throw new Exception("Failed to delete data with id : $id");
            }
            break;

        case 'view':
            $id = intval($_POST['id'] ?? 'unknow');
            if($id == 'unknow') throw new Exception("Invalid ID");
            $stmt = $pdo->prepare("SELECT * FROM jobs WHERE =?");
            $stmt->execute([$id]);
            $jobs = $stmt->fetch(PDO::FETCH_ASSOC);
            if($jobs) $response = ['success'=>true, 'data'=>$jobs];
            else throw new Exception("jobs not found");
            break;

        case 'bulk_view':
            $ids = $_POST['ids']; // array of IDs
            $in  = str_repeat('?,', count($ids) - 1) . '?';
            $stmt = $pdo->prepare("SELECT * FROM jobs WHERE id IN ($in)");
            $stmt->execute($ids);
            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success'=>true, 'data'=>$jobs]);
            exit;

        case 'bulk_edit':
            foreach($_POST['ids'] as $id){
                $stmt = $pdo->prepare("UPDATE jobs SET id=?, job_media=?, job_title=?, slug=?, job_description=?, job_deadline=?, company=?, job_category=?, job_media_type=?, title=?, description=?, requirements=?, salary_min=?, salary_max=?, location=?, employment_type=?, experience_level=?, remote_option=?, visa_sponsorship=?, relocation_assistance=?, status=?, created_at=?, updated_at=?, company_id=? WHERE =?");
                $stmt->execute([$id, $job_media, $job_title, $slug, $job_description, $job_deadline, $company, $job_category, $job_media_type, $title, $description, $requirements, $salary_min, $salary_max, $location, $employment_type, $experience_level, $remote_option, $visa_sponsorship, $relocation_assistance, $status, $created_at, $updated_at, $company_id,  $id]);
            }
            echo json_encode(['success'=>true,'message'=>'Data updated successfully']);
            exit;

        case 'copy':
            $id = intval($_POST['id'] ?? 'unknow');
            if($id == 'unknow') throw new Exception("Invalid ID");
            $stmt = $pdo->prepare("SELECT * FROM jobs WHERE =?");
            $stmt->execute([$id]);
            $jobs = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$jobs) throw new Exception("Data not found");

            $stmt = $pdo->prepare("INSERT INTO jobs (id, job_media, job_title, slug, job_description, job_deadline, company, job_category, job_media_type, title, description, requirements, salary_min, salary_max, location, employment_type, experience_level, remote_option, visa_sponsorship, relocation_assistance, status, created_at, updated_at, company_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email'], $jobs['email']]);
            $response = ['success'=>true, 'message'=>'new data is recorded', 'id'=>$pdo->lastInsertId()];
            break;
        case 'bulk_copy':
            if(empty($ids)) throw new Exception("No IDs provided");
            foreach($_POST['ids'] as $id){
                $id = trim($_POST['id'] ?? '');
        $job_media = trim($_POST['job_media'] ?? '');
        $job_title = trim($_POST['job_title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $job_description = trim($_POST['job_description'] ?? '');
        $job_deadline = trim($_POST['job_deadline'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $job_category = trim($_POST['job_category'] ?? '');
        $job_media_type = trim($_POST['job_media_type'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $requirements = trim($_POST['requirements'] ?? '');
        $salary_min = trim($_POST['salary_min'] ?? '');
        $salary_max = trim($_POST['salary_max'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $employment_type = trim($_POST['employment_type'] ?? '');
        $experience_level = trim($_POST['experience_level'] ?? '');
        $remote_option = trim($_POST['remote_option'] ?? '');
        $visa_sponsorship = trim($_POST['visa_sponsorship'] ?? '');
        $relocation_assistance = trim($_POST['relocation_assistance'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $created_at = trim($_POST['created_at'] ?? '');
        $updated_at = trim($_POST['updated_at'] ?? '');
        $company_id = trim($_POST['company_id'] ?? '');
        
                isNot(['id', 'job_media', 'job_title', 'slug', 'job_description', 'job_deadline', 'company', 'job_category', 'job_media_type', 'title', 'description', 'requirements', 'salary_min', 'salary_max', 'location', 'employment_type', 'experience_level', 'remote_option', 'visa_sponsorship', 'relocation_assistance', 'status', 'created_at', 'updated_at', 'company_id']);
                
                $stmt = $pdo->prepare("INSERT INTO jobs (id, job_media, job_title, slug, job_description, job_deadline, company, job_category, job_media_type, title, description, requirements, salary_min, salary_max, location, employment_type, experience_level, remote_option, visa_sponsorship, relocation_assistance, status, created_at, updated_at, company_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$id, $job_media, $job_title, $slug, $job_description, $job_deadline, $company, $job_category, $job_media_type, $title, $description, $requirements, $salary_min, $salary_max, $location, $employment_type, $experience_level, $remote_option, $visa_sponsorship, $relocation_assistance, $status, $created_at, $updated_at, $company_id]);
            }
            $response = ['success'=>true,'message'=>'data copied successfully'];
            break;
        case 'bulk_delete':
            if(empty($ids)) throw new Exception("No IDs provided");
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $pdo->prepare("DELETE FROM jobs WHERE  IN ($placeholders)");
            $stmt->execute($ids);
            $response = ['success'=>true, 'message'=>count($ids).' jobs deleted'];
            break;

        case 'copy_many':
            if(empty($ids)) throw new Exception("No IDs provided");
            $stmt = $pdo->prepare("SELECT * FROM jobs WHERE  IN (".implode(',', array_fill(0,count($ids),'?')).")");
            $stmt->execute($ids);
            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($jobs as $u){
                $stmt2 = $pdo->prepare("INSERT INTO jobs (id, job_media, job_title, slug, job_description, job_deadline, company, job_category, job_media_type, title, description, requirements, salary_min, salary_max, location, employment_type, experience_level, remote_option, visa_sponsorship, relocation_assistance, status, created_at, updated_at, company_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt2->execute([$u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email'], $u['email']]);
            }
            $response = ['success'=>true, 'message'=>count($jobs).' data copied (registed)'];
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
                        $stmt = $pdo->prepare("INSERT INTO jobs ($columns) VALUES ($placeholders)");

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
        $job_media = trim($_POST['job_media'] ?? '');
        $job_title = trim($_POST['job_title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $job_description = trim($_POST['job_description'] ?? '');
        $job_deadline = trim($_POST['job_deadline'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $job_category = trim($_POST['job_category'] ?? '');
        $job_media_type = trim($_POST['job_media_type'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $requirements = trim($_POST['requirements'] ?? '');
        $salary_min = trim($_POST['salary_min'] ?? '');
        $salary_max = trim($_POST['salary_max'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $employment_type = trim($_POST['employment_type'] ?? '');
        $experience_level = trim($_POST['experience_level'] ?? '');
        $remote_option = trim($_POST['remote_option'] ?? '');
        $visa_sponsorship = trim($_POST['visa_sponsorship'] ?? '');
        $relocation_assistance = trim($_POST['relocation_assistance'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $created_at = trim($_POST['created_at'] ?? '');
        $updated_at = trim($_POST['updated_at'] ?? '');
        $company_id = trim($_POST['company_id'] ?? '');
        
            if(!$status) throw new Exception("all field with * is required.");
            $stmt = $pdo->prepare("UPDATE jobs SET id=?, job_media=?, job_title=?, slug=?, job_description=?, job_deadline=?, company=?, job_category=?, job_media_type=?, title=?, description=?, requirements=?, salary_min=?, salary_max=?, location=?, employment_type=?, experience_level=?, remote_option=?, visa_sponsorship=?, relocation_assistance=?, status=?, created_at=?, updated_at=?, company_id=? WHERE  IN (".implode(',', array_fill(0,count($ids),'?')).")");
            $stmt->execute(array_merge([$id, $job_media, $job_title, $slug, $job_description, $job_deadline, $company, $job_category, $job_media_type, $title, $description, $requirements, $salary_min, $salary_max, $location, $employment_type, $experience_level, $remote_option, $visa_sponsorship, $relocation_assistance, $status, $created_at, $updated_at, $company_id, ], $ids));
            $response = ['success'=>true, 'message'=>count($ids).' data updated in jobs'];
            break;
        case 'inline_update':
            $id = intval($_POST['id']);
            $field = $_POST['field'];
            $value = $_POST['value'];

            $allowed_fields = ['id', 'job_media', 'job_title', 'slug', 'job_description', 'job_deadline', 'company', 'job_category', 'job_media_type', 'title', 'description', 'requirements', 'salary_min', 'salary_max', 'location', 'employment_type', 'experience_level', 'remote_option', 'visa_sponsorship', 'relocation_assistance', 'status', 'created_at', 'updated_at', 'company_id'];
            if (!in_array($field, $allowed_fields)) {
                echo json_encode(['success' => false, 'message' => 'Invalid field']);
                exit;
            }

            $unique = isUniqueLoop('jobs',[$field=>$value]);

            $unique_cols = unique_cols('jobs'); 
            if (in_array($field, $unique_cols)) {
                $unique = isUnique($table, $field, $value);
            }else{
                $unique = false;
            }

            if ($unique) {
                echo json_encode(['message' => $field." exists",'success' => false]);
                exit;
            }else{
                $stmt = $pdo->prepare("UPDATE jobs SET `$field` = :value WHERE id = :id");
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