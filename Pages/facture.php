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
    <br>
<body>
    


<div class="_reservation-container">
<?php
include '../Fonctions/scriptFacture.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_travers = isset($_POST['id_travers']) ? htmlspecialchars($_POST['id_travers']) : null;
    $desc_travers = isset($_POST['desc_travers']) ? htmlspecialchars($_POST['desc_travers']) : "";
    $date_travers = isset($_POST['date_travers']) ? htmlspecialchars($_POST['date_travers']) : "";
    $heure_travers = isset($_POST['heure_travers']) ? htmlspecialchars($_POST['heure_travers']) : "";
    $CP = isset($_POST['cp']) ? htmlspecialchars($_POST['cp']) : "";
    $ville = isset($_POST['ville']) ? htmlspecialchars($_POST['ville']) : "";


    $tel = isset($_POST['tel']) ? htmlspecialchars($_POST['tel']) : "";
    $mail = isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : "";
    $adresse = isset($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : "";
    $id_user = $_SESSION['user_id'];
    if (verifClient($id_user)==false){$id_client =AddClient($nom,$prenom,$adresse,$tel,$mail,$id_user);}else{$id_client=verifClient($id_user);}


    $nbA = isset($_POST['nbA']) ? htmlspecialchars($_POST['nbA']) : "";
    $prixA = isset($_POST['prixA']) ? htmlspecialchars($_POST['prixA']) : 0;
    $nbJ = isset($_POST['nbJ']) ? htmlspecialchars($_POST['nbJ']) : "";
    $prixJ = isset($_POST['prixJ']) ? htmlspecialchars($_POST['prixJ']) : 0;
    $nbE = isset($_POST['nbE']) ? htmlspecialchars($_POST['nbE']) : "";
    $prixE = isset($_POST['prixE']) ? htmlspecialchars($_POST['prixE']) : 0;
    $nbVi4 = isset($_POST['nbVi4']) ? htmlspecialchars($_POST['nbVi4']) : "";
    $prixVi4 = isset($_POST['prixVi4']) ? htmlspecialchars($_POST['prixVi4']) : 0;
    $nbVi5 = isset($_POST['nbVi5']) ? htmlspecialchars($_POST['nbVi5']) : "";
    $prixVi5 = isset($_POST['prixVi5']) ? htmlspecialchars($_POST['prixVi5']) : 0;
    $nbF = isset($_POST['nbF']) ? htmlspecialchars($_POST['nbF']) : "";
    $prixF = isset($_POST['prixF']) ? htmlspecialchars($_POST['prixF']) : 0;
    $nbCc = isset($_POST['nbCc']) ? htmlspecialchars($_POST['nbCc']) : "";
    $prixCc = isset($_POST['prixCc']) ? htmlspecialchars($_POST['prixCc']) : 0;
    $nbC = isset($_POST['nbC']) ? htmlspecialchars($_POST['nbC']) : "";
    $prixC = isset($_POST['prixC']) ? htmlspecialchars($_POST['prixC']) : 0;

    $prixTotal = 
    ($nbA  ? $nbA  * $prixA  : 0) +
    ($nbJ  ? $nbJ  * $prixJ  : 0) +
    ($nbE  ? $nbE  * $prixE  : 0) +
    ($nbVi4 ? $nbVi4 * $prixVi4 : 0) +
    ($nbVi5 ? $nbVi5 * $prixVi5 : 0) +
    ($nbF  ? $nbF  * $prixF  : 0) +
    ($nbCc ? $nbCc * $prixCc : 0) +
    ($nbC  ? $nbC  * $prixC : 0);


    $id_resa = AddResa($id_travers, $id_client);
    if ($id_resa) {
        echo "<h2>$desc_travers</h2>";
        echo "<p>Traversée n°$id_travers le $date_travers à $heure_travers</p>";
        echo "<p>Réservation sous le n°$id_resa de $nom</p>";
        echo "<p>$adresse $CP $ville</p>";
    } else {
        echo "<h2>Réservation non crée</h2>";
    }
} else {
    echo "<h2>Accès interdit</h2>";
}
?>
<table class ="_facture-table">
  <tbody>
    <?php if($nbA!=null){echo"<tr><td>Adulte</td><td>$nbA</td><td>$prixA €</td></tr>";}; ?>
    <?php if($nbJ!=null){echo"<tr><td>Junior 8 à 18 ans</td><td>$nbJ</td><td>$prixJ €</td></tr>";}; ?>
    <?php if($nbE!=null){echo"<tr><td>Enfant 0 à 7 ans</td><td>$nbE</td><td>$prixE €</td></tr>";}; ?>
    <?php if($nbVi4!=null){echo"<tr><td>Voiture long. inf. 4m</td><td>$nbVi4</td><td>$prixVi4 €</td></tr>";}; ?>
    <?php if($nbVi5!=null){echo"<tr><td>Voiture long. inf. 5m</td><td>$nbVi5</td><td>$prixVi5 €</td></tr>";}; ?>
    <?php if($nbF!=null){echo"<tr><td>Fourgon</td><td>$nbF</td><td>$prixF €</td></tr>";}; ?>
    <?php if($nbCc!=null){echo"<tr><td>Camping Car</td><td>$nbCc</td><td>$prixCc €</td></tr>";}; ?>
    <?php if($nbC!=null){echo"<tr><td>Camion</td><td>$nbC</td><td>$prixC €</td></tr>";}; ?>

  </tbody>
</table>

<form action="payer.php" method="POST">

            <input type="hidden" name="id_resa" value="<?php echo "$id_resa"?>" >
            <input type="hidden" name="nbA" value="<?php echo "$nbA"?>" >
            <input type="hidden" name="nbJ" value="<?php echo "$nbJ"?>" >
            <input type="hidden" name="nbE" value="<?php echo "$nbE"?>" >
            <input type="hidden" name="nbVi4" value="<?php echo "$nbVi4"?>" >
            <input type="hidden" name="nbVi5" value="<?php echo "$nbVi5"?>" >
            <input type="hidden" name="nbF" value="<?php echo "$nbF"?>" >
            <input type="hidden" name="nbCc" value="<?php echo "$nbCc"?>" >
            <input type="hidden" name="nbC" value="<?php echo "$nbC"?>" >

        <button class="_reservation-button" type="submit">Payer <?php echo "$prixTotal"?>€</button>
        </form>
      </div>
</body>