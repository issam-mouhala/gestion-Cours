<?php
header('Content-Type: application/json');

$host = 'localhost';
$db = 'db_prof';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    $stmt = $pdo->prepare("INSERT INTO publication (title, author, year,type, subject) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['titre'],
        $_POST['auteurs'],
        $_POST['annee'],
        $_POST['type'],
        $_POST['sujet']
    ]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>