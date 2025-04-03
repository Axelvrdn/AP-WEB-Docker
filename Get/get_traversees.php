<?php
include '../Fonctions/scriptReserver.php';

header('Content-Type: application/json');

if (!isset($_GET['nom_secteur']) || empty($_GET['nom_secteur'])) {
    echo json_encode([]);
    exit;
}

$nom_secteur = htmlspecialchars($_GET['nom_secteur'], ENT_QUOTES, 'UTF-8');
$descriptions = getDescTraversées($nom_secteur);

echo json_encode($descriptions);
?>
