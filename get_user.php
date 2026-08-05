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

    $sql = "SELECT f.id as filiere_nom FROM user u join filiere f on u.id_filiere=f.id  WHERE  u.id= :id";
    $stmt = $pdo->prepare($sql);
    
    // Exécution avec l'ID voulu
    $stmt->execute([':id' => $_POST["id"]]);
    
    // Récupération des résultats
    $resultats = $stmt->fetch(PDO::FETCH_ASSOC);

if($resultats){
    echo json_encode($resultats);

}else{
    
    echo json_encode(null);
}
} catch (\PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    echo json_encode(['error' => $e->getMessage()]);
}
?>