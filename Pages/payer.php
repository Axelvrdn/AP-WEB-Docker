<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Style/style.css">
    <title>MarieTeam</title>
</head>
<body>


    <?php
    // Inclure le fichier qui vérifie si l'utilisateur est connecté et récupère son prénom et nom
    include '../Fonctions/scriptUserConnecte.php'; 
    ?>

    
<?php if (isset($typerUser) && $typerUser === 'Gestionnaire'){
        include '../navbar/navbarAdmin.php';
    }else{
        include '../navbar/navbarClient.php';
    }?>

    <br>
<body>
<div class="_reservation-container">
<?php
include '../Fonctions/scriptPayer.php';

$id_resa = isset($_POST['id_resa']) ? htmlspecialchars($_POST['id_resa']) : null;
$nbA = isset($_POST['nbA']) ? htmlspecialchars($_POST['nbA']) : null;
$nbJ = isset($_POST['nbJ']) ? htmlspecialchars($_POST['nbJ']) : null;
$nbE = isset($_POST['nbE']) ? htmlspecialchars($_POST['nbE']) : null;
$nbVi4 = isset($_POST['nbVi4']) ? htmlspecialchars($_POST['nbVi4']) : null;
$nbVi5 = isset($_POST['nbVi5']) ? htmlspecialchars($_POST['nbVi5']) : null;
$nbF = isset($_POST['nbF']) ? htmlspecialchars($_POST['nbF']) : null;
$nbCc = isset($_POST['nbCc']) ? htmlspecialchars($_POST['nbCc']) : null;
$nbC = isset($_POST['nbC']) ? htmlspecialchars($_POST['nbC']) : null;

enregistrer($id_resa, $nbA, $nbJ, $nbE, $nbVi4, $nbVi5, $nbF, $nbCc, $nbC);

?>

<h1>Votre paiement a été effectué avec succès.</h1>

