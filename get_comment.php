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
    $pdo->exec("SET SESSION group_concat_max_len = 100000");

    // Requête paramétrée
    $sql = "
    SELECT 
     forum.*,user.nom,cours.titre from forum join user on user.id=forum.id_user  join cours on forum.id_cours=cours.id
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $resultats = $stmt->fetchAll();

    echo json_encode($resultats);
} catch (\PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
