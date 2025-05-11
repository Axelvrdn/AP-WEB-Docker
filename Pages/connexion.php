<?php
  include '../Fonctions/scriptConnexion.php'; // Inclure le fichier PHP
?>

<html lang="fr">
  <head>
    <link rel="stylesheet" type="text/css" href="../Style/style.css" />
    <meta charset="utf-8" />
    <title>MarieTeam</title>
    <script src="../JavaScript/validConnexion.js" defer></script> <!-- Inclure le fichier JavaScript -->
  </head>

  <body>



  <?php include '../navbar/navbarClient.php';?>


    <!-- Section principale de connexion -->
    <br><br><br><br>
    <section class="connexion">
        <h1>Connexion à votre <span class="titre1">Compte</span></h1>
        <br><br>
        <form method="POST" id="connexionForm">
            <div class="form-group">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" />
                <div id="errorEmailExist"></div> <!-- Zone d'erreur pour l'email -->
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password"  />
                <div id="errorPwd"></div> <!-- Zone d'erreur pour le mot de passe -->
            </div>
                    <!-- Affichage des erreurs -->
        <?php
        if (isset($_SESSION['error'])) {
            echo '<p class="error-message">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']); // Supprime l'erreur après affichage
        }
        ?>
            <button type="submit" class="btn-connexion">Connexion</button>
            <br><br>
            <p class="inscription">Si vous n'avez pas de compte, <a href="inscription.php">cliquez ici pour vous inscrire</a>.</p>
        </form>
    </section>
  </body>
</html>
