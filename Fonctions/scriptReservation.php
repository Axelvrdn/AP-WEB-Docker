<?php
include_once "../pdo/pdo.php";

function getReservationInfo($id) {
    global $pdo;
    $sql = "SELECT desc_travers, date_travers FROM `traversée` WHERE id_travers = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
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

Function MaxPlace($id_travers){
    global $pdo;
    $sql = "SELECT 
    -- Places disponibles pour les passagers (Catégorie 1)
    c1.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (1,2,3) THEN e.quantité END), 0) AS PlaceDispoPassagers,
    -- Places disponibles pour les véhicules < 2m (Catégorie 2)
    c2.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (4,5) THEN e.quantité END), 0) AS PlaceDispoVehiculesInf2m,
    -- Places disponibles pour les véhicules > 2m (Catégorie 3)
    c3.capac_bateau_pass - COALESCE(SUM(CASE WHEN e.id_type IN (6,7,8) THEN e.quantité END), 0) AS PlaceDispoVehiculesSup2m
FROM marieteam.traversée t
LEFT JOIN marieteam.reservation r ON t.id_travers = r.id_travers
LEFT JOIN marieteam.enregistrer e ON r.id_resa = e.id_resa
JOIN marieteam.bateau b ON t.id_bateau = b.id_bateau
LEFT JOIN marieteam.contenir c1 ON b.id_bateau = c1.id_bateau AND c1.id_cat = 1
LEFT JOIN marieteam.contenir c2 ON b.id_bateau = c2.id_bateau AND c2.id_cat = 2
LEFT JOIN marieteam.contenir c3 ON b.id_bateau = c3.id_bateau AND c3.id_cat = 3
WHERE t.date_travers > CURDATE() AND t.id_travers = :id_travers
GROUP BY t.id_travers, c1.capac_bateau_pass, c2.capac_bateau_pass, c3.capac_bateau_pass;
";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_travers', $id_travers, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function RecupClient($id_utilisateur){
    global $pdo;
    $sql = "SELECT * FROM client WHERE id_utilisateur= :id_utilisateur";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

