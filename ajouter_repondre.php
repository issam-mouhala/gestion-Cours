<?php
$host = 'localhost';
$db = 'db_prof';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
echo $_POST["message"];
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->exec("SET SESSION group_concat_max_len = 100000");

    $sql = "INSERT INTO repondre (content, id_comment,id_user) VALUES (:message, :id,:id_user)";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':message' => $_POST["message"],
        ':id' => $_POST["id"],
        ':id_user' => $_POST["id_user"]

    ]);

    echo json_encode(['success' => 'Insertion réussie.']);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>