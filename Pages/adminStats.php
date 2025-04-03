<?php
    include '../Fonctions/scriptUserConnecte.php'; 
    include '../Fonctions/scriptAdminStats.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Style/style.css">
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
            <li><a class="active" href="adminStats.php">Statistiques réservation</a></li>
            <li><a href="gestLiaison.php">Gestion des liaisons</a></li>
            <li><a href="profile.php"><b class="connexion-btn"><?php echo isset($prenom) ? $prenom . ' ' . $nom : 'Connexion'; ?></b></a></li>
          </div>
      </ul>
    </nav>

    <!-- Formulaire de sélection de période -->
    <div class="stats-form">
        <h2>Sélectionner une période</h2>
        <form class="form-stats" method="POST">
            <div class="form-group-stats">
                <label class="label-stats" for="startDate">Date de début</label>
                <input type="date" id="startDate" name="startDate" value="<?php echo htmlspecialchars($startDate); ?>" required>
            </div>
            <div class="form-group-stats">
                <label class="label-stats" for="endDate">Date de fin</label>
                <input type="date" id="endDate" name="endDate" value="<?php echo htmlspecialchars($endDate); ?>" required>
            </div>
            <button class="button-stats" type="submit">Afficher les statistiques</button>
        </form>
    </div>

    <?php if ($stats): ?>
    <!-- Grille des statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Chiffre d'affaires</h3>
            <p class="stat-value"><?php echo number_format($stats['revenue'], 2, ',', ' '); ?> €</p>
        </div>

        <div class="stat-card">
            <h3>Total Passagers</h3>
            <p class="stat-value">
                <?php
                $totalPassengers = array_reduce($stats['passengers'], function($carry, $item) {
                    return $carry + ($item['desc_type'] === 'Adulte' || $item['desc_type'] === 'Junior 8 à 18 ans' || $item['desc_type'] === 'Enfant 0 à 7' ? $item['total'] : 0);
                }, 0);
                echo $totalPassengers;
                ?>
            </p>
        </div>

        <div class="stat-card">
            <h3>Total Véhicules</h3>
            <p class="stat-value">
                <?php
                $totalVehicles = array_reduce($stats['passengers'], function($carry, $item) {
                    return $carry + (strpos($item['desc_type'], 'Voiture') !== false || strpos($item['desc_type'], 'Camion') !== false ? $item['total'] : 0);
                }, 0);
                echo $totalVehicles;
                ?>
            </p>
        </div>
    </div>

    <div class="details-section">
        <h3>Détails par catégorie</h3>
        <div class="details-list">
            <?php foreach ($stats['passengers'] as $passenger): ?>
            <div class="detail-item">
                <span><?php echo htmlspecialchars($passenger['desc_type']); ?></span>
                <span><?php echo $passenger['total']; ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
