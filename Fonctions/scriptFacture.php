<?php
include_once "../pdo/pdo.php";

function verifClient($id_user){
    global $pdo;
    $sql = "SELECT id_client FROM client WHERE id_utilisateur= :id_user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function AddClient($nom, $prenom, $adresse, $tel, $mail, $id_user) {
    global $pdo;
    $sql = "INSERT INTO `client` (`nom_client`, `prenom_client`, `adresse_client`, `tel_client`, `mail_client`, `id_utilisateur`) 
            VALUES (:nom, :prenom, :adresse, :tel, :mail, :id_user);";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    
    $stmt->execute();

    // Retourner l'ID du client inséré
    return $pdo->lastInsertId();
}

function AddResa($id_travers, $id_client) {
    global $pdo;
    try {
        $pdo->beginTransaction(); // Démarre une transaction pour éviter les incohérences en cas d'erreur

        // 1. Insérer la réservation
        $sql = "INSERT INTO `reservation` (`date_resa`, `id_travers`) VALUES (CURDATE(), :id_travers)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_travers', $id_travers, PDO::PARAM_INT);
        $stmt->execute();

        // 2. Récupérer l'ID de la réservation insérée
        $id_resa = $pdo->lastInsertId();

        // 3. Insérer dans la table `choisir`
        $sql = "INSERT INTO `choisir` (`id_client`, `id_resa`) VALUES (:id_client, :id_resa)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_client', $id_client, PDO::PARAM_INT);
        $stmt->bindValue(':id_resa', $id_resa, PDO::PARAM_INT);
        $stmt->execute();

        $pdo->commit(); // Valide la transaction
        return $id_resa; // Retourne l'ID de la réservation
    } catch (Exception $e) {
        $pdo->rollBack(); // Annule tout en cas d'erreur
        throw new Exception("Erreur lors de l'ajout de la réservation : " . $e->getMessage());
    }
}
