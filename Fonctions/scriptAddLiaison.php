<?php
include_once "../pdo/pdo.php";

function getBateaux() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id_bateau, nom_bateau FROM bateau");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getPorts() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id_port, nom_port FROM port");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getSecteurs() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id_secteur, nom_secteur FROM secteur");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getNomPort($id_port) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT nom_port FROM port WHERE id_port = :id_port");
    $stmt->bindParam(':id_port', $id_port, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getNomSecteur($id_secteur) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT nom_secteur FROM secteur WHERE id_secteur = :id_secteur");
    $stmt->bindParam(':id_secteur', $id_secteur, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getNomBateau($id_bateau) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT nom_bateau FROM bateau WHERE id_bateau = ?");
    $stmt->execute([$id_bateau]); // Exécuter la requête avec le paramètre $id_bateau
    return $stmt->fetchColumn();
}

function getBateauIdByNom($nom_bateau) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id_bateau FROM bateau WHERE nom_bateau = :nom_bateau");
    $stmt->bindParam(':nom_bateau', $nom_bateau, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getLiaisonIdByNom($id_travers) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id_liaison FROM liaison WHERE id_travers = ?");
    $stmt->execute([$id_travers]);
    return $stmt->fetchColumn();
}

function getDistLiaison($id_travers){
    global $pdo;
    $stmt = $pdo->prepare("SELECT dist_milles FROM liaison WHERE id_travers = ?");
    $stmt->execute([$id_travers]);
    return $stmt->fetchColumn();
}

function getSectLiaison($id_travers){
    global $pdo;
    $stmt = $pdo->prepare("SELECT id_secteur FROM liaison WHERE id_travers = ?");
    $stmt->execute([$id_travers]);
    return $stmt->fetchColumn();
}

function getPortDepLiaison($id_travers){
    global $pdo;
    $stmt = $pdo->prepare("SELECT port.id_port FROM port INNER JOIN 
    liaison ON liaison.id_port = port.id_port WHERE liaison.id_travers = ?");
    $stmt->execute([$id_travers]);
    return $stmt->fetchColumn();
}

function getPortArrLiaison($id_travers){
    global $pdo;
    $stmt = $pdo->prepare("SELECT port.id_port FROM port INNER JOIN 
    liaison ON liaison.id_port_1 = port.id_port WHERE liaison.id_travers = ?");
    $stmt->execute([$id_travers]);
    return $stmt->fetchColumn();
}



// Insertion réelle dans la BDD uniquement quand on confirme
function addTravers($date,$heure,$Description,$bateau) {
    global $pdo;
    $sql = "INSERT INTO traversée (date_travers, heure_travers, desc_travers, id_bateau)
            VALUES (:date, :heure, :description, :id_bateau)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':heure', $heure);
    $stmt->bindParam(':description', $Description);
    $stmt->bindParam(':id_bateau', $bateau);

    if ($stmt->execute()) {
        return $pdo->lastInsertId();
    }
    return false;
}

function addLiaison($distance_milles, $id_port_depart, $id_port_arrivee, $id_secteur, $id_traversee) {
    global $pdo;
    $sql = "INSERT INTO `liaison` (`id_liaison`, `dist_milles`, `id_port`, `id_port_1`, `id_secteur`, `id_travers`) 
            VALUES (NULL, :distance_miles, :id_port_depart, :id_port_arrivee, :id_secteur, :id_traversee)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':distance_miles', $distance_milles);
    $stmt->bindParam(':id_port_depart', $id_port_depart);
    $stmt->bindParam(':id_port_arrivee', $id_port_arrivee);
    $stmt->bindParam(':id_secteur', $id_secteur);
    $stmt->bindParam(':id_traversee', $id_traversee);

    if ($stmt->execute()) {
        return $pdo->lastInsertId();
    }
    return false;
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

    $prix = [];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $prix[$row['desc_type']] = $row['Tarif'];
    }

    return $prix;
}
?>
