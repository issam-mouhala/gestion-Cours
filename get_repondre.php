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
    SELECT repondre.id,date,id_comment,
     content , nom from repondre join user on user.id=repondre.id_user where id_comment=:id
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_REQUEST["id"]]);
    $resultats = $stmt->fetchAll();

    echo json_encode($resultats);
} catch (\PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
