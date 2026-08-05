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
      c.id,
      c.titre,
      c.description,
      c.semestre,
      c.niveau,

      (SELECT GROUP_CONCAT(f.comment SEPARATOR ',') FROM forum f WHERE f.id_cours = c.id) AS comments,
      (SELECT GROUP_CONCAT(f.date SEPARATOR ',') FROM forum f WHERE f.id_cours = c.id) AS comment_date,
      (SELECT GROUP_CONCAT(f.id SEPARATOR ',') FROM forum f WHERE f.id_cours = c.id) AS id_comments,
      (SELECT GROUP_CONCAT(user.nom SEPARATOR ',') FROM forum f JOIN user ON f.id_user = user.id WHERE f.id_cours = c.id) AS forum_users,
      (SELECT GROUP_CONCAT(user.nom SEPARATOR ',') FROM forum f JOIN repondre r ON f.id = r.id_comment JOIN user ON r.id_user = user.id WHERE f.id_cours = c.id) AS forum_users_repondre,
      (SELECT GROUP_CONCAT(r.content SEPARATOR ',') FROM forum f JOIN repondre r ON f.id = r.id_comment JOIN user ON r.id_user = user.id WHERE f.id_cours = c.id) AS forum_users_repondre_content,
      (SELECT GROUP_CONCAT(r.date SEPARATOR ',') FROM forum f JOIN repondre r ON f.id = r.id_comment JOIN user ON r.id_user = user.id WHERE f.id_cours = c.id) AS forum_users_repondre_date,
      (SELECT GROUP_CONCAT(r.id_comment SEPARATOR ',') FROM forum f JOIN repondre r ON f.id = r.id_comment JOIN user ON r.id_user = user.id WHERE f.id_cours = c.id) AS forum_users_repondre_id,

      (SELECT GROUP_CONCAT(a.annonce SEPARATOR ',') FROM annonces a WHERE a.id_cours = c.id) AS annonces,
      (SELECT GROUP_CONCAT(a.date SEPARATOR ',') FROM annonces a WHERE a.id_cours = c.id) AS annonces_dates,

      (SELECT GROUP_CONCAT(s.description_syllabus SEPARATOR ',') FROM syllabus s WHERE s.id_cours = c.id) AS syllabus_descriptions,
      (SELECT GROUP_CONCAT(s.titre_syllabus SEPARATOR ',') FROM syllabus s WHERE s.id_cours = c.id) AS syllabus_titres,
      (SELECT GROUP_CONCAT(s.id SEPARATOR ',') FROM syllabus s WHERE s.id_cours = c.id) AS syllabus_id_cours,

      (SELECT GROUP_CONCAT(m.id SEPARATOR ',') FROM materiels m JOIN syllabus s ON m.id_syllabus = s.id WHERE s.id_cours = c.id) AS materiels_id,
      (SELECT GROUP_CONCAT(m.name SEPARATOR ',') FROM materiels m JOIN syllabus s ON m.id_syllabus = s.id WHERE s.id_cours = c.id) AS materiels_name,
      (SELECT GROUP_CONCAT(m.id_syllabus SEPARATOR ',') FROM materiels m JOIN syllabus s ON m.id_syllabus = s.id WHERE s.id_cours = c.id) AS materiels_id_syllabus

    FROM cours c
  
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $resultats = $stmt->fetchAll();

    echo json_encode($resultats);
} catch (\PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
