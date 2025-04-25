<?php
include '../Fonctions/scriptReserverAdmin.php';

header('Content-Type: application/json');

if (isset($_GET['nom_secteur']) && !empty($_GET['nom_secteur'])) {
    $nom_secteur = htmlspecialchars($_GET['nom_secteur'], ENT_QUOTES, 'UTF-8');

    if (isset($_GET['desc_travers']) && !empty($_GET['desc_travers'])) {
        $desc_travers = htmlspecialchars($_GET['desc_travers'], ENT_QUOTES, 'UTF-8');

        if (isset($_GET['date_travers']) && !empty($_GET['date_travers'])) {
            $date_travers = htmlspecialchars($_GET['date_travers'], ENT_QUOTES, 'UTF-8');

            // Exécute la fonction avec 3 paramètres
            $infos = GetInfo3option($nom_secteur, $desc_travers, $date_travers);
        } else {
            // Exécute la fonction avec 2 paramètres
            $infos = GetInfo2Option($nom_secteur, $desc_travers);
        }
    } else {
        // Exécute la fonction avec 1 paramètre
        $infos = GetInfo1Option($nom_secteur);
    }

    echo json_encode($infos ?: []);
} else {
    echo json_encode(["error" => "Nom du secteur manquant"]);
}
?>
