<?php

function deleteTraverséeEtLiaison($id_travers) {
    global $pdo;

    // 1. Récupération de l'id_liaison lié à la traversée
    $stmt = $pdo->prepare("SELECT id_liaison FROM liaison WHERE id_travers = :id_travers");
    $stmt->bindParam(':id_travers', $id_travers, PDO::PARAM_INT);
    $stmt->execute();
    $id_liaison = $stmt->fetchColumn();

    if ($id_liaison) {
        // 2. Suppression des tarifs liés à cette liaison
        $stmt = $pdo->prepare("DELETE FROM tarifer WHERE id_liaison = :id_liaison");
        $stmt->bindParam(':id_liaison', $id_liaison, PDO::PARAM_INT);
        $stmt->execute();

        // 3. Suppression de la liaison
        $stmt = $pdo->prepare("DELETE FROM liaison WHERE id_liaison = :id_liaison");
        $stmt->bindParam(':id_liaison', $id_liaison, PDO::PARAM_INT);
        $stmt->execute();
    }

    // 4. Suppression de la traversée
    $stmt = $pdo->prepare("DELETE FROM traversée WHERE id_travers = :id_travers");
    $stmt->bindParam(':id_travers', $id_travers, PDO::PARAM_INT);
    $stmt->execute();
}


?>