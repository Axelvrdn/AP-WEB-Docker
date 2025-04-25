<?php
include_once "../pdo/pdo.php";

function modifTravers($id_travers,$date,$heure,$Description,$bateau) {
    global $pdo;
    $sql = "UPDATE traversée 
            SET date_travers = :date, heure_travers = :heure, desc_travers = :description, id_bateau = :id_bateau WHERE id_travers = :id_travers";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':heure', $heure);
    $stmt->bindParam(':description', $Description);
    $stmt->bindParam(':id_bateau', $bateau);
    $stmt->bindParam(':id_travers', $id_travers);

    return $stmt->execute();
}

function modifLiaison($id_liaison, $distance_milles, $id_port_depart, $id_port_arrivee, $id_secteur, $id_traversee) {
    global $pdo;
    $sql = "UPDATE liaison 
            SET dist_milles = :distance_miles, id_port = :id_port_depart, id_port_1 = :id_port_arrivee, id_secteur = :id_secteur, id_travers = :id_traversee 
            WHERE id_liaison = :id_liaison";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':distance_miles', $distance_milles);
    $stmt->bindParam(':id_port_depart', $id_port_depart);
    $stmt->bindParam(':id_port_arrivee', $id_port_arrivee);
    $stmt->bindParam(':id_secteur', $id_secteur);
    $stmt->bindParam(':id_traversee', $id_traversee);
    $stmt->bindParam(':id_liaison', $id_liaison);

    return $stmt->execute();
}


?>