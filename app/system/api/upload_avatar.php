<?php
session_start();
require_once '../cogs/db.php'; // adjust path

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_FILES['avatar_file'])) {
    echo json_encode(["status" => "error", "message" => "No file uploaded"]);
    exit;
}

$file = $_FILES['avatar_file'];
$targetDir = "../filemanager/images/avatars/";
$ext = pathinfo($file["name"], PATHINFO_EXTENSION);
$filename = "avatar_" . $user_id . "_" . time() . "." . $ext;
$targetPath = $targetDir . $filename;

// Create dir if not exists
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Move uploaded file
if (move_uploaded_file($file["tmp_name"], $targetPath)) {
    $avatar_url = $filename;

    // Update DB
    $stmt = $pdo->prepare("UPDATE user_profile SET avatar_url=? WHERE user_id=?");
    $stmt->execute([$avatar_url, $user_id]);

    echo json_encode(["status" => "success", "avatar_url" => $avatar_url]);
} else {
    echo json_encode(["status" => "error", "message" => "Upload failed"]);
}
