<?php
include '../Fonctions/scriptUserConnecte.php'; 
include '../Fonctions/scriptAddLiaison.php';

$ports = getPorts();
$secteurs = getSecteurs();

// Récupérer les données de la 1ère étape (formulaire précédent)
$date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : null;
$heure = isset($_POST['heure']) ? htmlspecialchars($_POST['heure']) : "";
$Description = isset($_POST['Description']) ? htmlspecialchars($_POST['Description']) : "";
$bateau = isset($_POST['bateau']) ? (int) $_POST['bateau'] : 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="../Style/style.css" />
  <title>MarieTeam</title>
</head>
<body>
<?php
    if ($_SESSION['typer_user'] === 'Gestionnaire')
  {?>
  <?php include '../navbar/navbarAdmin.php';?>


  <section class="connexion">
    <h2>Informations sur la traversée :</h2>
    <p>Traversée enregistrée pour le <?= $date ?> à <?= $heure ?> pour <?= $Description ?> avec le bateau <?= $bateau ?></p>

    <!-- Formulaire pour créer une nouvelle liaison -->
    <form action="addLiaisonTarif.php" method="POST">
      <!-- Infos précédentes cachées -->
      <input type="hidden" name="date" value="<?= $date ?>">
      <input type="hidden" name="heure" value="<?= $heure ?>">
      <input type="hidden" name="Description" value="<?= $Description ?>">
      <input type="hidden" name="bateau" value="<?= $bateau ?>">


      <h3>Créer une nouvelle liaison :</h3>
      <label for="distance_miles">Distance en miles :</label>
      <input type="number" step="0.1" name="distance_miles" required><br>

      <label for="port_depart">Port de départ :</label>
      <select name="port_depart">
        <?php foreach ($ports as $port): ?>
          <option value="<?= htmlspecialchars($port['id_port']) ?>"><?= htmlspecialchars($port['nom_port']) ?></option>
        <?php endforeach; ?>
      </select><br>

      <label for="port_arrivee">Port d'arrivée :</label>
      <select name="port_arrivee">
        <?php foreach ($ports as $port): ?>
          <option value="<?= htmlspecialchars($port['id_port']) ?>"><?= htmlspecialchars($port['nom_port']) ?></option>
        <?php endforeach; ?>
      </select><br>

      <label for="secteur">Secteur :</label>
      <select name="secteur">
        <?php foreach ($secteurs as $secteur): ?>
          <option value="<?= htmlspecialchars($secteur['id_secteur']) ?>"><?= htmlspecialchars($secteur['nom_secteur']) ?></option>
        <?php endforeach; ?>
      </select><br><br>

      <button type="submit" name="nouvelle_liaison">Créer la liaison</button>
    </form>
  </section>
  <?php 
      }
      else {
        header("Location: ../Pages/index.php"); // Page client
    }?> 
</body>
</html>
