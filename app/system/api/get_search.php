<?php
header('Content-Type: application/json');
include '../cogs/db.php';

$q = trim($_GET['q'] ?? '');
if (strlen($q) < 2) exit(json_encode([]));

$stmt = $pdo->prepare("
  SELECT id, title, keywords, url
  FROM search_index
  WHERE title LIKE :q OR keywords LIKE :q
  ORDER BY created_at DESC
  LIMIT 5
");
$stmt->execute(['q' => "%$q%"]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
