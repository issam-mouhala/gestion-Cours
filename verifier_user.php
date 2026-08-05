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
    

    $sql = "SELECT nom,id FROM user WHERE email = :email and password= :password";
    $stmt = $pdo->prepare($sql);
    
    // Exécution avec l'ID voulu
    $stmt->execute([':email' => $_REQUEST["email"],
    ':password' => $_REQUEST["password"]]);
    
    // Récupération des résultats
    $resultats = $stmt->fetch(PDO::FETCH_ASSOC);

 if($resultats){
// Start the session
session_start();

// Set session variables
$_SESSION["nom"] =$resultats["nom"] ;
$_SESSION["id"] = $resultats["id"];
    echo json_encode($resultats);

}else{
    
    echo json_encode("");
}
} catch (\PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    echo json_encode(['error' => $e->getMessage()]);
}
?>