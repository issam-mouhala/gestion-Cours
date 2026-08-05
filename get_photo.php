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

    $sql = "SELECT avatar FROM user WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_GET['id']]);

    $result = $stmt->fetch();

    if ($result && !empty($result['avatar'])) {
        // Convertit les données binaires en base64
        $base64 = base64_encode($result['avatar']);
        // Retourne avec un préfixe MIME pour affichage direct dans <img src="">
        echo json_encode(['avatar' => 'data:image/jpeg;base64,' . $base64]);
    } else {
        echo json_encode(['avatar' => null]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
