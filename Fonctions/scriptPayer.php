<?php
include_once "../pdo/pdo.php";

function enregistrer($id_resa, $nbA, $nbJ, $nbE, $nbVi4, $nbVi5, $nbF, $nbCc, $nbC) {
    global $pdo;
    $sql = "INSERT INTO `enregistrer` (`id_resa`, `id_type`, `quantité`) VALUES (:id_resa, '1', :nbA);
    INSERT INTO `enregistrer` (`id_resa`, `id_type`, `quantité`) VALUES (:id_resa, '2', :nbJ);
    INSERT INTO `enregistrer` (`id_resa`, `id_type`, `quantité`) VALUES (:id_resa, '3', :nbE);
    INSERT INTO `enregistrer` (`id_resa`, `id_type`, `quantité`) VALUES (:id_resa, '4', :nbVi4);
    INSERT INTO `enregistrer` (`id_resa`, `id_type`, `quantité`) VALUES (:id_resa, '5', :nbVi5);
    INSERT INTO `enregistrer` (`id_resa`, `id_type`, `quantité`) VALUES (:id_resa, '6', :nbF);
    INSERT INTO `enregistrer` (`id_resa`, `id_type`, `quantité`) VALUES (:id_resa, '7', :nbCc);
    INSERT INTO `enregistrer` (`id_resa`, `id_type`, `quantité`) VALUES (:id_resa, '8', :nbC );";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_resa', $id_resa, PDO::PARAM_INT);
    $stmt->bindParam(':nbA', $nbA, PDO::PARAM_INT);
    $stmt->bindParam(':nbJ', $nbJ, PDO::PARAM_INT);
    $stmt->bindParam(':nbE', $nbE, PDO::PARAM_INT);
    $stmt->bindParam(':nbVi4', $nbVi4, PDO::PARAM_INT);
    $stmt->bindParam(':nbVi5', $nbVi5, PDO::PARAM_INT);
    $stmt->bindParam(':nbF', $nbF, PDO::PARAM_INT);
    $stmt->bindParam(':nbCc', $nbCc, PDO::PARAM_INT);
    $stmt->bindParam(':nbC', $nbC, PDO::PARAM_INT);
    
    $stmt->execute();
}

