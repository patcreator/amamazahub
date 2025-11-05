<?php
require '../../cogs/db.php';
$id = $_POST['id'];
$email = $_POST['email'];
$status = $_POST['status'];

$stmt = $pdo->prepare("UPDATE subscribers SET email = :email, status = :status WHERE id = :id");
$stmt->execute(['email' => $email, 'status' => $status, 'id' => $id]);
?>
