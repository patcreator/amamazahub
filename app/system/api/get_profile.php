<?php
try {
    $stmt = $pdo->prepare("SELECT * FROM user_profile WHERE user_id = ? LIMIT 1");
    $stmt->execute([$_SESSION['user_id']]);
    $active_user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('User not found');
}

?>