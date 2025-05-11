<!-- navbarAdmin.php -->
<nav class="menu">
  <ul>
    <?php if ($_SESSION['typer_user'] === 'Gestionnaire'): ?>
      <li class="titre-marieteam"><a href="../Pages/accueilAdmin.php"><b>MarieTeam</b></a></li>
    <?php else: ?>
      <li class="titre-marieteam"><a href="../Pages/index.php"><b>MarieTeam</b></a></li>
    <?php endif; ?>        

    <div class="nav-buttons">
      <li><a href="../Pages/reserver.php">Réserver</a></li>

      <?php if (isset($prenom) && isset($nom)): ?>
        <li><a href="../Pages/adminStats.php">Statistiques réservation</a></li>
      <?php else: ?>
        <li><a href="../Pages/connexion.php">Réserver</a></li>
      <?php endif; ?>

      <li><a href="../Pages/gestLiaison.php">Gestion des liaisons</a></li>

      <?php if (isset($prenom) && isset($nom)): ?>
        <li><a href="../Pages/profile.php"><b class="connexion-btn"><?php echo $prenom . ' ' . $nom; ?></b></a></li>
      <?php else: ?>
        <li><a href="../Pages/connexion.php"><b class="connexion-btn">Connexion</b></a></li>
      <?php endif; ?>
    </div>
  </ul>
</nav>
