<?php
    // Inclure le fichier qui vérifie si l'utilisateur est connecté et récupère son prénom et nom
    include '../Fonctions/scriptUserConnecte.php'; 
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

        <?php if (isset($prenom) && isset($nom)): ?>
            <li><a href="adminStats.php">Statistiques réservation</a></li>
          <?php else: ?>
            <li><a href="connexion.php">Réserver</a></li>
          <?php endif; ?>

          <li><a href="gestLiaison.php" class="active">Gestion des liaisons</a></li>

          <?php if (isset($prenom) && isset($nom)): ?>
            <li><a href="profile.php"><b class="connexion-btn"><?php echo $prenom . ' ' . $nom; ?></b></a></li>
          <?php else: ?>
            <li><a href="connexion.php"><b class="connexion-btn">Connexion</b></a></li>
          <?php endif; ?>
        </div>
      </ul>
    </nav>

    <?php
        include '../Fonctions/scriptReserverAdmin.php';

        // Récupérer tous les secteurs
        $secteurs = getSecteurs();
        $infos = GetInfo();
    ?>

<div class="blockR">
        <div class="destination">
            <ul>
            <?php foreach ($secteurs as $secteurItem): ?>
                    <?php echo htmlspecialchars($secteurItem['nom_secteur']); ?>
                    <button type="button" onclick="selectionnerSecteur('<?php echo htmlspecialchars($secteurItem['nom_secteur']); ?>')">
                        Sélectionner
                    </button>
            <?php endforeach; ?>
            </ul>
        </div>

        <div class="tableauReservation">
            <select name="traversee" data-nom-secteur="<?= htmlspecialchars($nom_secteur) ?>" onchange="selectionnerTraversee(this.value)">
                <option value="">Sélectionner une traversée</option>
                <?php foreach ($descriptions as $desc) : ?>
                    <option value="<?= htmlspecialchars($desc) ?>"><?= htmlspecialchars($desc) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="date_traversee" id="date_traversee">
                <option value="">Sélectionner une date</option>
            </select>
        </div>
    </div>
    <form id="selectionForm" action="modificationLiaison.php" method="POST">
        <!-- Champs cachés pour stocker les infos -->
        <input type="hidden" name="id_travers" id="id_travers_field">
        <input type="hidden" name="desc_travers" id="desc_travers_field">
        <input type="hidden" name="date_travers" id="date_travers_field">
        <input type="hidden" name="heure_travers" id="heure_travers_field">
        <input type="hidden" name="nom_bateau" id="nom_bateau_field">



        <table>
            <thead>
                <tr>
                    <th colspan="5">Traversée</th>
                    <th colspan="3">Places disponibles</th>
                    <th>Sélectionner</th>
                </tr>
                <tr>
                    <th>N°</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Bateau</th>
                    <th>Passager</th>
                    <th>Véhicule Inf 2m</th>
                    <th>Véhicule Sup 2m</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($infos as $info) : ?>
                    <tr>
                        <td><?= htmlspecialchars($info['id_travers']) ?></td>
                        <td><?= htmlspecialchars($info['desc_travers']) ?></td>
                        <td><?= htmlspecialchars($info['date_travers']) ?></td>
                        <td><?= htmlspecialchars($info['heure_travers']) ?></td>
                        <td><?= htmlspecialchars($info['nom_bateau']) ?></td>
                        <td><?= htmlspecialchars($info['Passager']) ?></td>
                        <td><?= htmlspecialchars($info['véhicule inf2m']) ?></td>
                        <td><?= htmlspecialchars($info['véhicule sup2m']) ?></td>
                        <td>
                            <input type="radio" name="id_travers" value="<?= htmlspecialchars($info['id_travers']) ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit">Valider la sélection</button>
    </form>

    
    <script src="../JavaScript/ScriptRéserverAdmin.js"></script>

</body>
</html>
