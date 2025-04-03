<?php
include_once "../pdo/pdo.php";


// Fonction pour récupérer les secteurs
function getSecteurs() {
    global $pdo;
    $sql = "SELECT nom_secteur 
            FROM secteur 
            INNER JOIN liaison ON liaison.id_secteur = secteur.id_secteur
            INNER JOIN traversée ON traversée.id_travers = liaison.id_travers
            WHERE traversée.date_travers > CURRENT_DATE
            GROUP BY secteur.nom_secteur";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}

function getIdSecteurs($nom_secteur) {
    global $pdo;
    $sql = "SELECT id_secteur 
            FROM secteur
            WHERE nom_secteur=:nom_secteur";
    

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom_secteur', $nom_secteur, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll();
}


// Fonction pour récupérer les descriptions des traversées
function getDescTraversées($nom_secteur) {
    global $pdo;
    $sql = "SELECT DISTINCT traversée.desc_travers
            FROM liaison
            INNER JOIN traversée ON liaison.id_travers = traversée.id_travers
            INNER JOIN secteur ON liaison.id_secteur = secteur.id_secteur
            WHERE secteur.nom_secteur = :nom_secteur 
            AND traversée.date_travers > CURRENT_DATE
            AND traversée.desc_travers IS NOT NULL";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom_secteur', $nom_secteur, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function GetDateTravers($desc_travers) {
    global $pdo;
    $sql = "SELECT DISTINCT traversée.date_travers
            FROM traversée
            WHERE traversée.desc_travers = :desc_travers
            AND traversée.date_travers > CURRENT_DATE";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':desc_travers', $desc_travers, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function GetInfo() {
    global $pdo;
    $sql = "SELECT 
    t.id_travers,
    t.heure_travers,
    b.nom_bateau,
    -- Places disponibles pour les passagers (Catégorie 1)
    c1.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (1,2,3) THEN e.quantité END), 0) AS Passager,
    -- Places disponibles pour les véhicules < 2m (Catégorie 2)
    c2.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (4,5) THEN e.quantité END), 0) AS `véhicule inf2m`,
    -- Places disponibles pour les véhicules > 2m (Catégorie 3)
    c3.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (6,7,8) THEN e.quantité END), 0) AS `véhicule sup2m`
FROM marieteam.traversée t
LEFT JOIN marieteam.reservation r ON t.id_travers = r.id_travers
LEFT JOIN marieteam.enregistrer e ON r.id_resa = e.id_resa
JOIN marieteam.bateau b ON t.id_bateau = b.id_bateau
LEFT JOIN marieteam.contenir c1 ON b.id_bateau = c1.id_bateau AND c1.id_cat = 1
LEFT JOIN marieteam.contenir c2 ON b.id_bateau = c2.id_bateau AND c2.id_cat = 2
LEFT JOIN marieteam.contenir c3 ON b.id_bateau = c3.id_bateau AND c3.id_cat = 3
WHERE t.date_travers > CURDATE()
GROUP BY t.id_travers, t.heure_travers, b.nom_bateau, c1.capac_bateau_pass, c2.capac_bateau_pass, c3.capac_bateau_pass;";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function GetInfo1Option($nom_secteur) {
    global $pdo;
    $sql = "SELECT 
    t.id_travers,
    t.heure_travers,
    b.nom_bateau,
    -- Places disponibles pour les passagers (Catégorie 1)
    c1.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (1,2,3) THEN e.quantité END), 0) AS Passager,
    -- Places disponibles pour les véhicules < 2m (Catégorie 2)
    c2.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (4,5) THEN e.quantité END), 0) AS `véhicule inf2m`,
    -- Places disponibles pour les véhicules > 2m (Catégorie 3)
    c3.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (6,7,8) THEN e.quantité END), 0) AS `véhicule sup2m`
FROM marieteam.traversée t
LEFT JOIN marieteam.reservation r ON t.id_travers = r.id_travers
LEFT JOIN marieteam.enregistrer e ON r.id_resa = e.id_resa
JOIN marieteam.bateau b ON t.id_bateau = b.id_bateau
LEFT JOIN marieteam.contenir c1 ON b.id_bateau = c1.id_bateau AND c1.id_cat = 1
LEFT JOIN marieteam.contenir c2 ON b.id_bateau = c2.id_bateau AND c2.id_cat = 2
LEFT JOIN marieteam.contenir c3 ON b.id_bateau = c3.id_bateau AND c3.id_cat = 3
JOIN liaison l ON t.id_travers = l.id_travers
JOIN secteur s ON l.id_secteur = s.id_secteur
WHERE t.date_travers > CURDATE() AND s.nom_secteur = :nom_secteur
GROUP BY t.id_travers, t.heure_travers, b.nom_bateau, c1.capac_bateau_pass, c2.capac_bateau_pass, c3.capac_bateau_pass;";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom_secteur', $nom_secteur, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function GetInfo2option($nom_secteur, $desc_travers) {
    global $pdo;
    $sql = "SELECT 
    t.id_travers,
    t.heure_travers,
    b.nom_bateau,
    -- Places disponibles pour les passagers (Catégorie 1)
    c1.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (1,2,3) THEN e.quantité END), 0) AS Passager,
    -- Places disponibles pour les véhicules < 2m (Catégorie 2)
    c2.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (4,5) THEN e.quantité END), 0) AS `véhicule inf2m`,
    -- Places disponibles pour les véhicules > 2m (Catégorie 3)
    c3.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (6,7,8) THEN e.quantité END), 0) AS `véhicule sup2m`
FROM marieteam.traversée t
LEFT JOIN marieteam.reservation r ON t.id_travers = r.id_travers
LEFT JOIN marieteam.enregistrer e ON r.id_resa = e.id_resa
JOIN marieteam.bateau b ON t.id_bateau = b.id_bateau
LEFT JOIN marieteam.contenir c1 ON b.id_bateau = c1.id_bateau AND c1.id_cat = 1
LEFT JOIN marieteam.contenir c2 ON b.id_bateau = c2.id_bateau AND c2.id_cat = 2
LEFT JOIN marieteam.contenir c3 ON b.id_bateau = c3.id_bateau AND c3.id_cat = 3
JOIN liaison l ON t.id_travers = l.id_travers
JOIN secteur s ON l.id_secteur = s.id_secteur
WHERE t.date_travers > CURDATE() AND s.nom_secteur = :nom_secteur AND t.desc_travers= :desc_travers
GROUP BY t.id_travers, t.heure_travers, b.nom_bateau, c1.capac_bateau_pass, c2.capac_bateau_pass, c3.capac_bateau_pass;";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom_secteur', $nom_secteur, PDO::PARAM_STR);
    $stmt->bindParam(':desc_travers', $desc_travers, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function GetInfo3option($nom_secteur, $desc_travers, $date_travers) {
    global $pdo;
    $sql = "SELECT 
    t.id_travers,
    t.heure_travers,
    b.nom_bateau,
    -- Places disponibles pour les passagers (Catégorie 1)
    c1.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (1,2,3) THEN e.quantité END), 0) AS Passager,
    -- Places disponibles pour les véhicules < 2m (Catégorie 2)
    c2.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (4,5) THEN e.quantité END), 0) AS `véhicule inf2m`,
    -- Places disponibles pour les véhicules > 2m (Catégorie 3)
    c3.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (6,7,8) THEN e.quantité END), 0) AS `véhicule sup2m`
FROM marieteam.traversée t
LEFT JOIN marieteam.reservation r ON t.id_travers = r.id_travers
LEFT JOIN marieteam.enregistrer e ON r.id_resa = e.id_resa
JOIN marieteam.bateau b ON t.id_bateau = b.id_bateau
LEFT JOIN marieteam.contenir c1 ON b.id_bateau = c1.id_bateau AND c1.id_cat = 1
LEFT JOIN marieteam.contenir c2 ON b.id_bateau = c2.id_bateau AND c2.id_cat = 2
LEFT JOIN marieteam.contenir c3 ON b.id_bateau = c3.id_bateau AND c3.id_cat = 3
JOIN liaison l ON t.id_travers = l.id_travers
JOIN secteur s ON l.id_secteur = s.id_secteur
WHERE t.date_travers > CURDATE() AND s.nom_secteur = :nom_secteur AND t.desc_travers= :desc_travers AND t.date_travers = :date_travers
GROUP BY t.id_travers, t.heure_travers, b.nom_bateau, c1.capac_bateau_pass, c2.capac_bateau_pass, c3.capac_bateau_pass;";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom_secteur', $nom_secteur, PDO::PARAM_STR);
    $stmt->bindParam(':desc_travers', $desc_travers, PDO::PARAM_STR);
    $stmt->bindParam(':date_travers', $date_travers, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



// Récupere les secteurs qui ont des traversers après la date du jour
$sql = "SELECT nom_secteur 
FROM secteur
INNER JOIN liaison ON liaison.id_secteur = secteur.id_secteur
INNER JOIN traversée ON traversée.id_travers = liaison.id_travers
WHERE traversée.date_travers > CURRENT_DATE
GROUP BY secteur.nom_secteur";


//Récupere les descriptions des traversers après la date du jour par rapport au secteurs choisis
$sql = "SELECT  traversée.desc_travers
FROM liaison
INNER JOIN traversée ON liaison.id_travers = traversée.id_travers
WHERE id_secteur = 1 AND traversée.date_travers > CURRENT_DATE
GROUP BY traversée.desc_travers";


//Récupere les dates des traversers après la date du jour par rapport a la description des traversers choisis
$sql = "SELECT  traversée.date_travers
FROM liaison
INNER JOIN traversée ON liaison.id_travers = traversée.id_travers
WHERE traversée.desc_travers = 'Quiberon-Le Palais' AND traversée.date_travers > CURRENT_DATE
GROUP BY traversée.date_travers";


$sql = "SELECT id_travers, heure_travers, bateau.nom_bateau , contenir.capac_bateau_pass - COUNT()
FROM traversée
INNER JOIN bateau ON traversée.id_bateau = bateau.id_bateau
WHERE heure_travers = '07:45:00'";

$sql = "SELECT COUNT(quantité)
FROM enregistrer
INNER JOIN reservation ON enregistrer.id_resa = reservation.id_resa
INNER JOIN traversée ON reservation.id_travers = traversée.id_travers
WHERE traversée.date_travers =";

?>