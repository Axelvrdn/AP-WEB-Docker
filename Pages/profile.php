<?php
  // Inclure le fichier qui vérifie si l'utilisateur est connecté et récupère son prénom et nom
  include '../Fonctions/scriptUserConnecte.php'; 
  include '../Fonctions/scriptProfile.php'; 
?>

<html lang="fr">
  <head>
    <link rel="stylesheet" type="text/css" href="../Style/style.css" />
    <meta charset="utf-8" />
    <title>MarieTeam</title>
    <script src="../JavaScript/validUpdate.js" defer></script> <!-- Inclure le fichier JavaScript -->

  </head>

  <body>

    <!-- Barre de navigation -->
    <nav class="menu">
      <ul>
          <?php if ($_SESSION['typer_user'] === 'Gestionnaire'): ?>
          <li class="titre-marieteam"><a href="accueilAdmin.php"><b>MarieTeam</b></a></li>
          <?php else: ?>
              <li class="titre-marieteam"><a href="index.php"><b>MarieTeam</b></a></li>
          <?php endif; ?>        <div class="nav-buttons">


          <?php if ($_SESSION['typer_user'] === 'Gestionnaire'): ?>
          <li class="titre-marieteam"><a href="accueilAdmin.php">Accueil</a></li>
          <?php else: ?>
              <li class="titre-marieteam"><a href="index.php">Accueil</a></li>
          <?php endif; ?>
          
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
        <h1>Modifiez vos <span class="titre1">informations</span></h1>
        <br><br>
        <form action="profile.php" method="POST" id="leForm"> <!-- Action vers le même fichier pour traitement -->
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required />
                <div id="errorNom"></div> <!-- Zone d'erreur pour le nom -->
            </div>
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required />
                <div id="errorPrenom"></div> <!-- Zone d'erreur pour le prénom -->
            </div>
            <div class="form-group">
                <label for="email">Adresse mail :</label>
                <input type="email" id="email" name="email" required />
                <div id="errorEmailExist" class="error"></div>
                <div id="errorEmailInvalid" class="error"></div> <!-- Zones d'erreur pour email -->
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required />
                <div id="errorPwd"></div> <!-- Zone d'erreur pour le mot de passe -->
                <div id="erreurUpdate"></div> <!-- Zone d'erreur pour l'inscription -->
            </div>
            <?php
              if (isset($_SESSION['messageUpdate'])) {
                  echo '<div id="messageUpdate">' . $_SESSION['messageUpdate'] . '</div>';
                  unset($_SESSION['messageUpdate']);
              }
            ?>
            <button type="submit" class="btn-connexion" >Enregistrer les modifications</button><br>
            <button type="button" class="btn-deconnexion" onclick="window.location.href='../Fonctions/scriptDeconnexion.php'">Déconnexion</button>
        </form>
    </section>

  </body>
</html>
