<?php
require '../../cogs/db.php';
$email = $_POST['email'];
$status = $_POST['status'];

$stmt = $pdo->prepare("INSERT INTO subscribers (email, status) VALUES (:email, :status)");
$stmt->execute(['email' => $email, 'status' => $status]);
?>
