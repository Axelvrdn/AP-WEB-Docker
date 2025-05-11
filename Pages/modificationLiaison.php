<?php
  include '../Fonctions/scriptUserConnecte.php'; 
  include '../Fonctions/scriptAddLiaison.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
      include '../Fonctions/scriptSuppLiaison.php';
      deleteTraverséeEtLiaison($_POST['id_travers']);
      header("Location: modification.php");
      exit;
    } else {
      include '../Fonctions/scriptSuppLiaison.php';
    }
  }



  // Récupérer les valeurs envoyées par POST pour pré-remplir le formulaire
  $desc_travers = isset($_POST['desc_travers']) ? $_POST['desc_travers'] : '';
  $date_travers = isset($_POST['date_travers']) ? $_POST['date_travers'] : '';
  $heure_travers = isset($_POST['heure_travers']) ? $_POST['heure_travers'] : '';
  $id_travers = isset($_POST['id_travers']) ? $_POST['id_travers'] : '';
  $nom_bateau = isset($_POST['nom_bateau']) ? $_POST['nom_bateau'] : '';

  
  // Récupération des données liées à la traversée
  $distance = getDistLiaison($id_travers);
  $port_depart_id = getPortDepLiaison($id_travers);
  $port_arrivee_id = getPortArrLiaison($id_travers);
  $secteur_id = getSectLiaison($id_travers);

  $bateaux = getBateaux();
  $ports = getPorts();
  $secteurs = getSecteurs();
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


    <br><br><br><br>
    <section class="connexion">
      <h1>Modifier une <span class="titre1">traversée</span></h1><br>
      <form method="POST" action="modificationTarifLiaison.php">
        <!-- ID Traversée (caché) -->
        <input type="hidden" name="id_travers" value="<?= htmlspecialchars($id_travers) ?>">

        <input type="hidden" name="date_travers" id="date_travers_field">
        <input type="hidden" name="heure_travers" id="heure_travers_field">
        <input type="hidden" name="desc_travers" id="desc_travers_field">
        <input type="hidden" name="nom_bateau" id="nom_bateau_field">


        <div class="form-group">
          <label for="date">Date :</label>
          <input type="date" id="date" name="date_travers" value="<?= htmlspecialchars($date_travers) ?>" required>
        </div>

        <div class="form-group">
          <label for="heure">Heure :</label>
          <input type="time" id="heure" name="heure_travers" value="<?= htmlspecialchars($heure_travers) ?>" required>
        </div>

        <div class="form-group">
          <label for="desc">Description :</label>
          <input type="text" id="desc" name="desc_travers" value="<?= htmlspecialchars($desc_travers) ?>" required>
        </div>

        <div class="form-group">
          <label for="bateau">Bateau :</label>
          <select id="bateau" name="bateau" required>
            <option value="">--Choisissez un bateau--</option>
            <?php foreach ($bateaux as $bateau): ?>
              <option value="<?= htmlspecialchars($bateau['nom_bateau']) ?>"
                <?= ($nom_bateau === $bateau['nom_bateau']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($bateau['nom_bateau']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="distance_miles">Distance en miles :</label>
          <input type="number" step="0.1" name="distance" value="<?= htmlspecialchars($distance) ?>" required><br>
        </div>

        <div class="form-group">
          <label for="port_depart">Port de départ :</label>
          <select name="port_depart">
            <?php foreach ($ports as $port): ?>
              <option value="<?= $port['id_port'] ?>" <?= $port['id_port'] == $port_depart_id ? 'selected' : '' ?>>
                <?= htmlspecialchars($port['nom_port']) ?>
              </option>
            <?php endforeach; ?>
          </select><br>
        </div>

        <div class="form-group">
          <label for="port_arrivee">Port d'arrivée :</label>
          <select name="port_arrivee">
            <?php foreach ($ports as $port): ?>
              <option value="<?= $port['id_port'] ?>" <?= $port['id_port'] == $port_arrivee_id ? 'selected' : '' ?>>
                <?= htmlspecialchars($port['nom_port']) ?>
              </option>
            <?php endforeach; ?>
          </select><br>
        </div>

        <div class="form-group">
          <label for="secteur">Secteur :</label>
          <select name="secteur">
            <?php foreach ($secteurs as $secteur): ?>
              <option value="<?= $secteur['id_secteur'] ?>" <?= $secteur['id_secteur'] == $secteur_id ? 'selected' : '' ?>>
                <?= htmlspecialchars($secteur['nom_secteur']) ?>
              </option>
            <?php endforeach; ?>
          </select><br><br>
        </div>

        <?php if (isset($_SESSION['messageUpdate'])): ?>
            <p style="color: green;"><?= $_SESSION['messageUpdate'] ?></p>
            <?php unset($_SESSION['messageUpdate']); ?>
        <?php endif; ?>

        
          <button type="submit" name="modif" class="btn-connexion">Enregistrer les modifications</button><br>
        </form>

        <form method="POST" action="modificationLiaison.php">
        <input type="hidden" name="id_travers" value="<?= htmlspecialchars($id_travers) ?>">
        <button type="submit" name="delete" class="btn-deconnexion" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette traversée ?')">Supprimer la traversée<button>      
        </form>
    </section>
    <?php 
      }
      else {
        header("Location: ../Pages/index.php"); // Page client
    }?> 
</body>
</html>
