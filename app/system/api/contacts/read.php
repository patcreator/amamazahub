<?php
header('Content-Type: application/json');
require '../../cogs/db.php';

$stmt = $pdo->query("SELECT * FROM contacts ORDER BY id DESC");
echo json_encode($stmt->fetchAll());
?>
