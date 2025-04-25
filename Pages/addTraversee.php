<?php
  // Inclure le fichier qui vérifie si l'utilisateur est connecté et récupère son prénom et nom
  include '../Fonctions/scriptUserConnecte.php'; 
  include '../Fonctions/scriptAddLiaison.php';
  $bateaux = getBateaux();
  
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

    <br><br><br><br>
    <section class="connexion">
        <h1>Ajoutez une <span class="titre1">traversée</span></h1>
        <br><br>
        <form action="addLiaison.php" method="POST" id="leForm"> <!-- Action vers le même fichier pour traitement -->
          <input type="hidden" name="date_travers" id="date_travers_field">
          <input type="hidden" name="heure_travers" id="heure_travers_field">
          <input type="hidden" name="desc_travers" id="desc_travers_field">
          <input type="hidden" name="nom_bateau" id="nom_bateau_field">
          
            <div class="form-group">
                <label for="date">Date :</label>
                <input type="date" id="date" name="date" >
                <div id="errorDate"></div> <!-- Zone d'erreur pour le nom -->
            </div>
            <div class="form-group">
                <label for="heure">Heure :</label>
                <input type="time" id="heure" name="heure" >
                <div id="errorHeure"></div> <!-- Zone d'erreur pour le prénom -->
            </div>
            <div class="form-group">
                <label for="Description">Description :</label>
                <input type="Description" id="Description" name="Description" />
                <div id="errorDescription" class="error"></div>
            </div>
            <div class="form-group">
                <label for="bateau">Sélectionnez un bateau :</label>
                <select name="bateau">
                  <?php foreach (getBateaux() as $b): ?>
                    <option value="<?= $b['id_bateau'] ?>"><?= $b['nom_bateau'] ?></option>
                  <?php endforeach; ?>
                </select>
                <div id="errorAdd"></div> <!-- Zone d'erreur pour l'inscription -->
            </div>
            <?php
              if (isset($_SESSION['messageUpdate'])) {
                  echo '<div id="messageUpdate">' . $_SESSION['messageUpdate'] . '</div>';
                  unset($_SESSION['messageUpdate']);
              }
            ?>
            <button type="submit" class="btn-connexion" >Enregistrer les modifications</button><br>
        </form>
    </section>

  </body>
</html>
