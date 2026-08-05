<?php
session_start();

// Authentification réussie :
$_SESSION["id"] = $resultats["id"];
$_SESSION["nom"] = $resultats["nom"];

echo json_encode(["success" => true]);
