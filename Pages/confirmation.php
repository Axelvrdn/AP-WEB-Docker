<?php

include '../Fonctions/scriptUserConnecte.php'; 
include '../Fonctions/scriptAddLiaison.php';
$ports = getPorts();
$secteurs = getSecteurs();
  
?>
<html lang="fr">
  <head>
    <link rel="stylesheet" type="text/css" href="../Style/style.css" />
    <meta charset="utf-8" />
    <title>MarieTeam</title>
    <script src="../JavaScript/validAddLiaison.js" defer></script> <!-- Inclure le fichier JavaScript -->

  </head>

  <body>

    <!-- Barre de navigation -->
    <nav class="menu">
      <ul>
          <?php if ($_SESSION['typer_user'] === 'Gestionnaire'): ?>
          <li class="titre-marieteam"><a href="accueilAdmin.php"><b>MarieTeam</b></a></li>
          <?php else: ?>
          <li class="titre-marieteam"><a href="index.php"><b>MarieTeam</b></a></li>
          <?php endif; ?>        
          
          <div class="nav-buttons">

        <?php if (isset($prenom) && isset($nom)): ?>
            <li><a href="adminStats.php">Statistiques réservation</a></li>
          <?php else: ?>
            <li><a href="connexion.php">Réserver</a></li>
          <?php endif; ?>

          <li><a class="active" href="gestLiaison.php">Gestion des liaisons</a></li>

          <?php if (isset($prenom) && isset($nom)): ?>
            <li><a href="profile.php"><b class="connexion-btn"><?php echo $prenom . ' ' . $nom; ?></b></a></li>
          <?php else: ?>
            <li><a href="connexion.php"><b class="connexion-btn">Connexion</b></a></li>
          <?php endif; ?>
        </div>
      </ul>
    </nav>
<html lang="fr">
<head>
  <title>Confirmation Liaison</title>
</head>
<body>
    <br><br><br><br>
    <section class="connexion">
        <h2>Informations sur la traversée :</h2>
        <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : null;
                $heure = isset($_POST['heure']) ? htmlspecialchars($_POST['heure']) : "";
                $Description = isset($_POST['Description']) ? htmlspecialchars($_POST['Description']) : "";
                $bateau = isset($_POST['bateau']) ? htmlspecialchars($_POST['bateau']) : "";

            }
            echo "<p>Traversée enregistré pour le $date à $heure pour $Description avec le bateau $bateau</p>";
            
            
        ?>

    
        <form action="addLiaisonTarif.php" method="POST" id="leForm">
            <input type="hidden" name="date" value="<?php echo "$date"?>">
            <input type="hidden" name="heure" value="<?php echo "$heure"?>">
            <input type="hidden" name="Description" value="<?php echo "$Description"?>">
            <input type="hidden" name="bateau" value="<?php echo "$bateau"?>">
        <h3>Créer une nouvelle liaison :</h3>
        <label for="distance_miles">Distance en miles :</label>
        <input type="number" name="distance_miles" required><br>

        <label for="port_depart">Port de départ :</label>
        <select name="port_depart">
            <?php foreach ($ports as $port): ?>
                <option value="<?= htmlspecialchars($port['id_port']) ?>"><?= htmlspecialchars($port['nom_port']) ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="port_arrivee">Port d'arrivée :</label>
        <select name="port_arrivee">
            <?php foreach ($ports as $port): ?>
                <option value="<?= htmlspecialchars($port['id_port']) ?>"><?= htmlspecialchars($port['nom_port']) ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="secteur">Secteur :</label>
        <select name="secteur">
            <?php foreach ($secteurs as $secteur): ?>
                <option value="<?= htmlspecialchars($secteur['id_secteur']) ?>"><?= htmlspecialchars($secteur['nom_secteur']) ?></option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit" name="nouvelle_liaison">Créer une nouvelle liaison</button><br>
    </form>
  </section>
</body>
</html>
