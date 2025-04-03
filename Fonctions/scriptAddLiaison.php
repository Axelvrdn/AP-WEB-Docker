<?php

include_once "../pdo/pdo.php";

function getBateaux() {
    global $pdo;
    $sql = "SELECT id_bateau, nom_bateau FROM bateau";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getPorts() {
    global $pdo;
    $sql = "SELECT id_port, nom_port FROM port";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getSecteurs() {
    global $pdo;
    $sql = "SELECT id_secteur, nom_secteur FROM secteur";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}


function stockerTraverséeEnSession($data) {
    global $pdo;
    $sql = "INSERT INTO traversée (date_travers, heure_travers, desc_travers, id_bateau) VALUES (:date, :heure, :description, :id_bateau)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':date', $data['date']);
    $stmt->bindParam(':heure', $data['heure']);
    $stmt->bindParam(':description', $data['Description']);
    $stmt->bindParam(':id_bateau', $data['bateau']);
    
    if ($stmt->execute()) {
        $id_traversée = $pdo->lastInsertId();
        return $id_traversée;
    }
}
function Prix($id_travers) {
    global $pdo;
    $sql = "SELECT type.desc_type, tarifer.Tarif 
            FROM liaison
            INNER JOIN tarifer ON liaison.id_liaison = tarifer.id_liaison
            INNER JOIN type ON tarifer.id_type = type.id_type 
            WHERE liaison.id_travers = :id_travers
            GROUP BY type.desc_type";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_travers', $id_travers, PDO::PARAM_INT);
    $stmt->execute();

    // Transformer les résultats en tableau associatif clé = desc_type, valeur = Tarif
    $prix = [];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $prix[$row['desc_type']] = $row['Tarif'];
    }

    return $prix;
}

function ajouterLiaison($data) {
    global $pdo;
    
    // Insérer une nouvelle liaison
    $sql = "INSERT INTO liaison (distance_milles, id_port, id_port_1, id_secteur, id_travers) 
            VALUES (:distance_miles, :id_port_depart, :id_port_arrivee, :id_secteur, :id_traversée)";
    
    // Préparer la requête
    $stmt = $pdo->prepare($sql);
    
    // Associer les valeurs
    $stmt->bindParam(':distance_miles', $data['distance_milles']);
    $stmt->bindParam(':id_port_depart', $data['id_port_depart']);
    $stmt->bindParam(':id_port_arrivee', $data['id_port_arrivee']);
    $stmt->bindParam(':id_secteur', $data['id_secteur']);
    $stmt->bindParam(':id_traversée', $_SESSION['traversée']['id_traversée']); // Traversée associée
    
    return $stmt->execute();
}
?>
