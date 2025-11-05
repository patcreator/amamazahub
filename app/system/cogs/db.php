<?php
$host = 'localhost';
$db   = '1000hills';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$env = 'test';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
// PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
?>