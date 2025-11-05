<?php
require '../../cogs/db.php';
$id = $_POST['id'];

$stmt = $pdo->prepare("DELETE FROM subscribers WHERE id = :id");
$stmt->execute(['id' => $id]);
?>
