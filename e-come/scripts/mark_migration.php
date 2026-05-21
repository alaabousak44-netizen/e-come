<?php
$host = '127.0.0.1';
$port = 3306;
$user = 'root';
$pass = '';
$db = 'laravel';
$migration = '2026_05_21_013048_create_sessions_table';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->query('SELECT IFNULL(MAX(batch), 0) as max_batch FROM migrations');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $next = ((int)$row['max_batch']) + 1;
    $insert = $pdo->prepare('INSERT INTO migrations (migration, batch) VALUES (:migration, :batch)');
    $insert->execute(['migration' => $migration, 'batch' => $next]);
    echo "OK\n";
    exit(0);
} catch (Throwable $e) {
    echo "ERR: " . $e->getMessage() . "\n";
    exit(1);
}
