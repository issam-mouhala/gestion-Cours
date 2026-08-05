<?php
$host = 'localhost';
$dbname = 'db_prof';
$user = 'root';
$pass = '';

try {
    // Connexion sans base
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création de la base si elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    $pdo->exec("USE `$dbname`");

    // Création des tables
    $tables = [

        "CREATE TABLE IF NOT EXISTS `annonces` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_cours` INT(11) NOT NULL,
            `annonce` VARCHAR(1000) NOT NULL,
            `date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `cours` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `titre` VARCHAR(100) NOT NULL,
            `description` TEXT NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `forum` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_cours` INT(11) NOT NULL,
            `question` VARCHAR(1000) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `materiels` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_cours` INT(11) NOT NULL,
            `nom_fichier` VARCHAR(100) NOT NULL,
            `chemin` VARCHAR(200) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `repondre` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_forum` INT(11) NOT NULL,
            `reponse` TEXT NOT NULL,
            `date_rep` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `syllabus` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_cours` INT(11) NOT NULL,
            `description_syllabus` TEXT NOT NULL,
            `titre_syllabus` VARCHAR(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `user` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `nom` VARCHAR(20) NOT NULL,
            `email` VARCHAR(50) NOT NULL UNIQUE,
            `password` VARCHAR(50) NOT NULL,
            `prenom` VARCHAR(20) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;"
    ];

    foreach ($tables as $query) {
        $pdo->exec($query);
    }

    echo "Base de données et toutes les tables créées avec succès.";

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>