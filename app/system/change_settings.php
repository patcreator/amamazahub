<?php
include 'cogs/db.php'; // your db connection

header('Content-Type: application/json');
$id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Missing ID']);
    exit;
}

if (isset($_FILES['logo'])) {
    $target = 'uploads/' . basename($_FILES['logo']['name']);
    move_uploaded_file($_FILES['logo']['tmp_name'], $target);
    $new_value = $target;
} else {
    $new_value = $_GET['new_value'] ?? null;
}

if ($new_value === null) {
    echo json_encode(['success' => false, 'message' => 'No value provided']);
    exit;
}

$stmt = $pdo->prepare("UPDATE settings SET value = ? WHERE id = ?");
$ok = $stmt->execute([$new_value, $id]);

echo json_encode([
    'success' => $ok,
    'message' => $ok ? 'Setting updated successfully' : 'Update failed'
]);
?>
