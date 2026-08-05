<?php
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
    if($_REQUEST["type"]=="forum"){
            $sql = "DELETE FROM forum where id=:id";

    }
    if($_REQUEST["type"]=="repondre"){
        $sql = "DELETE FROM repondre where id=:id";
}
if ($_REQUEST["type"] == "users") {
    $sql = "DELETE FROM user WHERE id = :id";
}
if ($_REQUEST["type"] == "course") {
    $sql = "DELETE FROM cours WHERE id = :id";
}
if ($_REQUEST["type"] == "publication") {
    $sql = "DELETE FROM publication WHERE id = :id";
}
if ($_REQUEST["type"] == "contact") {
    $sql = "DELETE FROM contact WHERE id = :id";
}
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id' => $_POST["id"],
    ]);

    echo json_encode(['success' => 'suppression réussie.']);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>