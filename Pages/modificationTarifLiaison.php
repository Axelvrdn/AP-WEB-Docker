<?php
include '../Fonctions/scriptUserConnecte.php'; 
include '../Fonctions/scriptAddLiaison.php';
include '../Fonctions/scriptModifierAdmin.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_travers = isset($_POST['id_travers']) ? htmlspecialchars($_POST['id_travers']) : "";
    $date = isset($_POST['date_travers']) ? htmlspecialchars($_POST['date_travers']) : null;
    $heure = isset($_POST['heure_travers']) ? htmlspecialchars($_POST['heure_travers']) : "";
    $Description = isset($_POST['desc_travers']) ? htmlspecialchars($_POST['desc_travers']) : "";
    $nom_bateau = isset($_POST['bateau']) ? htmlspecialchars($_POST['bateau']) : "";

    $distance_miles = isset($_POST['distance']) ? htmlspecialchars($_POST['distance']) : "";
    $id_port_depart = isset($_POST['port_depart']) ? htmlspecialchars($_POST['port_depart']) : "";
    $id_port_arrivee = isset($_POST['port_arrivee']) ? htmlspecialchars($_POST['port_arrivee']) : "";
    $secteur = isset($_POST['secteur']) ? htmlspecialchars($_POST['secteur']) : "";

    // Récupération des noms depuis la BDD
    $id_liaison = getLiaisonIdByNom($id_travers);
    $bateau = getBateauIdByNom($nom_bateau);
    $nom_port_depart = getNomPort($id_port_depart);
    $nom_port_arrivee = getNomPort($id_port_arrivee);
    $nom_secteur = getNomSecteur($secteur);

    // Stockage de la traversée
    modifTravers($id_travers, $date,$heure,$Description,$bateau);
    if ($id_travers) {
      modifLiaison($id_liaison,$distance_miles, $id_port_depart, $id_port_arrivee, $secteur, $id_travers);
      $prix = Prix($id_liaison);
    } else {
        echo "<p>Erreur lors de la modification de la traversée.</p>";
    }
}

// Récupere les infos
$prix = Prix($id_travers);
// Récupérer les Prix
$prixA   = $prix['Adulte'] ?? 0;
$prixJ   = $prix['Junior 8 à 18 ans'] ?? 0;
$prixE   = $prix['Enfant 0 à 7'] ?? 0;
$prixVi4 = $prix['Voiture long.inf.4m'] ?? 0;
$prixVi5 = $prix['Voiture long.inf.5m'] ?? 0;
$prixF   = $prix['Fourgon'] ?? 0;
$prixCc  = $prix['Camping Car'] ?? 0;
$prixC   = $prix['Camion'] ?? 0;
?>




<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../Style/style.css">
  <title>MarieTeam</title>
</head>
<body>
  <!-- Navigation -->
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
          <li><a href="profile.php"><b class="connexion-btn"><?= $prenom . ' ' . $nom ?></b></a></li>
        <?php else: ?>
          <li><a href="connexion.php"><b class="connexion-btn">Connexion</b></a></li>
        <?php endif; ?>
      </div>
    </ul>
  </nav>

  <div class="_reservation-container">
    <p>
    Traversée enregistrée pour le <?= $date ?> à <?= $heure ?> avec le bateau <?= $nom_bateau ?>
    pour la liaison de <?= $nom_port_depart ?> jusqu'à <?= $nom_port_arrivee ?> 
    avec une distance de <?= $distance_miles ?> miles dans le secteur <?= $nom_secteur ?>.
    </p>

    <form class="_reservation-form" action="accueilAdmin.php" method="POST">
      <table class="_reservation-table">
            <thead>
                <tr>
                    <th>Catégorie</th>
                    <th>Tarif en €</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Adulte</td>
                    <td><?php echo $prixA ?></td>
                </tr>
                <tr>
                    <td>Junior 8 à 18 ans</td>
                    <td><?php echo $prixJ ?></td>
                </tr>
                <tr>
                    <td>Enfant 0 à 7 ans</td>
                    <td><?php echo $prixE ?></td>
                </tr>
                <tr>
                    <td>Voiture long. inf. 4m</td>
                    <td><?php echo $prixVi4 ?></td>
                </tr>
                <tr>
                    <td>Voiture long. inf. 5m</td>
                    <td><?php echo $prixVi5 ?></td>
                </tr>
                <tr>
                    <td>Fourgon</td>
                    <td><?php echo $prixF ?></td>
                </tr>
                <tr>
                    <td>Camping Car</td>
                    <td><?php echo $prixCc ?></td>
                </tr>
                <tr>
                    <td>Camion</td>
                    <td><?php echo $prixC ?></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn-connexion" >Accueil</button>
    </form>
  </div>
</body>
</html>
