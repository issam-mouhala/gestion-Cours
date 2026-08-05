<?php
header('Content-Type: application/json');

// Connexion
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

    // Vérification des champs
    if (
        !isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['password']) ||
        !isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK
    ) {
        echo json_encode(['error' => 'Données incomplètes ou fichier invalide']);
        exit;
    }

    // Lire le contenu binaire de l'image
    $avatarBlob = file_get_contents($_FILES['avatar']['tmp_name']);

    // Insertion en base de données
    $stmt = $pdo->prepare("INSERT INTO user (nom, prenom, email, password, avatar) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $_POST['nom']);
    $stmt->bindParam(2, $_POST['prenom']);
    $stmt->bindParam(3, $_POST['email']);
    $stmt->bindParam(4, $_POST['password']);
    $stmt->bindParam(5, $avatarBlob, PDO::PARAM_LOB);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Utilisateur avec image BLOB ajouté avec succès']);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
