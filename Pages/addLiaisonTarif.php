<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Style/style.css">
    <title>MarieTeam</title>
</head>
<body>


    <?php
    // Inclure le fichier qui vérifie si l'utilisateur est connecté et récupère son prénom et nom
    include '../Fonctions/scriptUserConnecte.php'; 
    include '../Fonctions/scriptAddLiaison.php';
    ?>

    
    <!-- Barre de navigation -->
    <nav class="menu">
      <ul>
        <?php if ($_SESSION['typer_user'] === 'Gestionnaire'): ?>
          <li class="titre-marieteam"><a href="accueilAdmin.php"><b>MarieTeam</b></a></li>
          <?php else: ?>
              <li class="titre-marieteam"><a href="index.php"><b>MarieTeam</b></a></li>
          <?php endif; ?>        <div class="nav-buttons">

        <?php if (isset($prenom) && isset($nom)): ?>
            <li><a class='active' href="reserver.php">Réserver</a></li>
          <?php else: ?>
            <li><a href="connexion.php">Réserver</a></li>
          <?php endif; ?>

          <li><a href="index.php">À propos</a></li>

          <?php if (isset($prenom) && isset($nom)): ?>
            <li><a href="profile.php"><b class="connexion-btn"><?php echo $prenom . ' ' . $nom; ?></b></a></li>
          <?php else: ?>
            <li><a href="connexion.php"><b class="connexion-btn">Connexion</b></a></li>
          <?php endif; ?>
        </div>
      </ul>
    </nav>
<body>
    <br>
    


<div class="_reservation-container">
<?php

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : null;
                $heure = isset($_POST['heure']) ? htmlspecialchars($_POST['heure']) : "";
                $Description = isset($_POST['Description']) ? htmlspecialchars($_POST['Description']) : "";
                $bateau = isset($_POST['bateau']) ? htmlspecialchars($_POST['bateau']) : "";

            }
            echo "<p>Traversée enregistré pour le $date à $heure pour $Description avec le bateau $bateau</p>";
            
            
?>




<?php
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


<form class="_reservation-form" action="facture.php" method="POST">
            
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
        <button class="_reservation-button" type="submit">Enregistrer la réservation</button>
        </form>
    </div>
</body>