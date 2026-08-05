
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    $file = $_FILES['pdf'];

    if ($file['type'] === 'application/pdf') {
        $pdo = new PDO("mysql:host=localhost;dbname=db_prof;charset=utf8mb4", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $stmt = $pdo->prepare("INSERT INTO materiels (name, type, content,id_syllabus,id_cours) VALUES (?,?,? ?, ?)");
        $stmt->execute([
            $file['name'], $_REQUEST['syllabus'], $_REQUEST['cours'],
            $file['type'],
            file_get_contents($file['tmp_name'])
        ]);

        echo "PDF ajouté avec succès.";
    } else {
        echo "Le fichier doit être un PDF.";
    }
}