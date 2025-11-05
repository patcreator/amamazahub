<?php
require '../../cogs/db.php';

$statuses = ['unseen', 'seen', 'unsubscribed'];
for ($i = 1; $i <= 100; $i++) {
    $email = "user{$i}@example.com";
    $status = $statuses[array_rand($statuses)];
    $stmt = $pdo->prepare("INSERT INTO subscribers (email, status) VALUES (:email, :status)");
    $stmt->execute(['email' => $email, 'status' => $status]);
}

echo "✅ 100 subscribers added successfully!";
?>
