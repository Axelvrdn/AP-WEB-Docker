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


    <!-- Section principale de bienvenue -->
    <br><br><br><br>
    <section class="intro">
      <h1>Bienvenue sur l'administration de <span class="titre1">MarieTeam</span></h1>
      <p>
      MarieTeam vous offre un accès complet à la gestion des liaisons maritimes et à l'administration des réservations. En tant qu'administrateur, vous avez la possibilité de gérer les liaisons, 
      modifier les informations de chaque traversée, ou ajouter de nouvelles liaisons selon les besoins. <br><br>
      Grâce à l'interface intuitive, vous pouvez également consulter les statistiques des réservations en temps réel, 
      ce qui vous permet de suivre l'activité de votre flotte, de gérer la capacité des navires, et d'optimiser la gestion des places disponibles. <br><br>
      Que vous soyez en train de gérer les horaires ou d'analyser les réservations, notre tableau de bord vous fournit toutes les informations nécessaires pour prendre des décisions 
      éclairées et assurer le bon fonctionnement des services maritimes.
      </p>
    </section>

    <!-- Ligne de séparation -->
    <hr class="separator" />

    <!-- Section de réservation -->
    <section class="reservation">
      <h1>Gestion des <span class="titre2">liaisons</span></h1>
      <p>
      Ajoutez, modifiez ou supprimez des liaisons maritimes en quelques clics. Gérez les horaires, les destinations et les informations relatives aux traversées.
      </p>
      <button class="btn-reserver" id="addLiaisonBtn">Gestion</button>
    </section>

    <!-- Ligne de séparation -->
    <hr class="separator" />

    <!-- Section de réservation -->
    <section class="reservation">
      <h1>Statistiques des <span class="titre2">réservations</span></h1>
      <p>
      Accédez à des rapports détaillés sur les réservations, consultez le nombre de passagers réservés pour chaque traversée et optimisez la gestion des disponibilités. 
      Vous avez également la possibilité de visualiser les tendances de réservation et d'anticiper les besoins futurs.
      </p>
      <button class="btn-reserver" id="adminStatsBtn">Statistiques</button>
    </section>

    <script>
    // Ajouter un gestionnaire d'événements au bouton
    document.getElementById('addLiaisonBtn').addEventListener('click', function() {
      <?php if (isset($prenom) && isset($nom)): ?>
        window.location.href = 'gestLiaison.php'; // Redirige vers la page de réservation si connecté
      <?php else: ?>
        window.location.href = 'connexion.php'; // Redirige vers la page de connexion si non connecté
      <?php endif; ?>
    });

    // Ajouter un gestionnaire d'événements au bouton
    document.getElementById('adminStatsBtn').addEventListener('click', function() {
      <?php if (isset($prenom) && isset($nom)): ?>
        window.location.href = 'adminStats.php'; // Redirige vers la page de réservation si connecté
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
