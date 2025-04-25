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

    
    <!-- Barre de navigation -->
    <nav class="menu">
      <ul>
        <?php if ($_SESSION['typer_user'] === 'Gestionnaire'): ?>
          <li class="titre-marieteam"><a href="accueilAdmin.php"><b>MarieTeam</b></a></li>
          <?php else: ?>
              <li class="titre-marieteam"><a href="index.php"><b>MarieTeam</b></a></li>
          <?php endif; ?>        <div class="nav-buttons">

        <?php if (isset($prenom) && isset($nom)): ?>
            <li><a class='active' href="reserver.php">Réserver</a></li>
          <?php else: ?>
            <li><a href="connexion.php">Réserver</a></li>
          <?php endif; ?>

          <li><a href="index.php">À propos</a></li>

          <?php if (isset($prenom) && isset($nom)): ?>
            <li><a href="profile.php"><b class="connexion-btn"><?php echo $prenom . ' ' . $nom; ?></b></a></li>
          <?php else: ?>
            <li><a href="connexion.php"><b class="connexion-btn">Connexion</b></a></li>
          <?php endif; ?>
        </div>
      </ul>
    </nav>
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

