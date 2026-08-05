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

    $sql = "SELECT content, name, type FROM materiels WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_GET["id"]]);

    $fichier = $stmt->fetch();

    if ($fichier) {
        header('Content-Type: ' . $fichier['type']); // ex: application/pdf
        header('Content-Disposition: inline; filename="' . $fichier['name'] . '"');
        echo $fichier['content']; // afficher directement le contenu binaire
        exit;
    } else {
        http_response_code(404);
        echo "Fichier non trouvé.";
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "Erreur serveur : " . $e->getMessage();
}
?>
<!--
<form action="" method="post" enctype="multipart/form-data">
    <label>Choisir un PDF :</label>
    <input type="file" name="pdf" accept="application/pdf" required>
    <input type="submit" value="Uploader">
</form>
-->
<?php
/*if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    $file = $_FILES['pdf'];

    if ($file['type'] === 'application/pdf') {
        $pdo = new PDO("mysql:host=localhost;dbname=db_prof;charset=utf8mb4", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $stmt = $pdo->prepare("INSERT INTO materiels (name, type, content) VALUES (?, ?, ?)");
        $stmt->execute([
            $file['name'],
            $file['type'],
            file_get_contents($file['tmp_name'])
        ]);

        echo "PDF ajouté avec succès.";
    } else {
        echo "Le fichier doit être un PDF.";
    }
}*/
?>
