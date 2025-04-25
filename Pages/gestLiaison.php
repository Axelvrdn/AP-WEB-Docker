<?php
  // Inclure le fichier qui vérifie si l'utilisateur est connecté et récupère son prénom et nom
  include '../Fonctions/scriptUserConnecte.php'; 
?>

<html lang="fr">
  <head>
    <link rel="stylesheet" type="text/css" href="../Style/style.css" />
    <meta charset="utf-8" />
    <title>MarieTeam</title>
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

    <div class="container-add">
      <button class="btn-add" id="addTraversee">Ajouter</button>
      <button class="btn-add" id="modification">Modifier</button>
    </div>

    <script>
    // Ajouter un gestionnaire d'événements au bouton
    document.getElementById('addTraversee').addEventListener('click', function() {
      <?php if (isset($prenom) && isset($nom)): ?>
        window.location.href = 'addTraversee.php'; // Redirige vers la page de réservation si connecté
      <?php else: ?>
        window.location.href = 'connexion.php'; // Redirige vers la page de connexion si non connecté
      <?php endif; ?>
    });

    // Ajouter un gestionnaire d'événements au bouton
    document.getElementById('modification').addEventListener('click', function() {
      <?php if (isset($prenom) && isset($nom)): ?>
        window.location.href = 'modification.php'; // Redirige vers la page de réservation si connecté
      <?php else: ?>
        window.location.href = 'connexion.php'; // Redirige vers la page de connexion si non connecté
      <?php endif; ?>
    });
    </script>
  </body>
</html>
