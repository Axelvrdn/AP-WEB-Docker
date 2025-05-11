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
  <?php
    if ($_SESSION['typer_user'] === 'Gestionnaire')
  {?>
  <?php include '../navbar/navbarAdmin.php';?>


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
      <?php 
      }
      else {
        header("Location: ../Pages/index.php"); // Page client
    }?> 
  </body>
</html>
