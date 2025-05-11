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

    
<?php if (isset($typerUser) && $typerUser === 'Gestionnaire'){
        include '../navbar/navbarAdmin.php';
    }else{
        include '../navbar/navbarClient.php';
    }?>

<body>
    <br>
    


<div class="_reservation-container">
<?php
include '../Fonctions/scriptReservation.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_travers = isset($_POST['id_travers']) ? htmlspecialchars($_POST['id_travers']) : null;
    $desc_travers = isset($_POST['desc_travers']) ? htmlspecialchars($_POST['desc_travers']) : "";
    $date_travers = isset($_POST['date_travers']) ? htmlspecialchars($_POST['date_travers']) : "";
    $heure_travers = isset($_POST['heure_travers']) ? htmlspecialchars($_POST['heure_travers']) : "Non spécifiée";

    // Si desc_travers ou date_travers sont vides, récupérer les infos via la BDD
    if (empty($desc_travers) || empty($date_travers)) {
        if ($id_travers) {
            $reservationInfo = getReservationInfo($id_travers);

            // Vérifier si la requête a retourné un résultat
            if ($reservationInfo) {
                $desc_travers = $reservationInfo['desc_travers'] ?? "Non spécifiée";
                $date_travers = $reservationInfo['date_travers'] ?? "Non spécifiée";
            }
        }
    }

    if ($id_travers) {
        echo "<h2>$desc_travers</h2>";
        echo "<p>Traversée n°$id_travers le $date_travers à $heure_travers</p>";
    } else {
        echo "<h2>Aucune traversée sélectionnée</h2>";
    }
} else {
    echo "<h2>Accès interdit</h2>";
}
?>




<?php
// Récupere les infos
$prix = Prix($id_travers);
$max = MaxPlace($id_travers);


// Récupérer les Prix
$prixA   = $prix['Adulte'] ?? 0;
$prixJ   = $prix['Junior 8 à 18 ans'] ?? 0;
$prixE   = $prix['Enfant 0 à 7'] ?? 0;
$prixVi4 = $prix['Voiture long.inf.4m'] ?? 0;
$prixVi5 = $prix['Voiture long.inf.5m'] ?? 0;
$prixF   = $prix['Fourgon'] ?? 0;
$prixCc  = $prix['Camping Car'] ?? 0;
$prixC   = $prix['Camion'] ?? 0;

// Récupérer les quantités maximales
$maxP = $max['PlaceDispoPassagers'] ?? 0;
$maxVi = $max['PlaceDispoVehiculesInf2m'] ?? 0;
$maxVs = $max['PlaceDispoVehiculesSup2m'] ?? 0;


?>

<?php
$id_utilisateur = $_SESSION['user_id'];
$client = RecupClient($id_utilisateur);
?>

<div id="reservation-data"
    data-maxp="<?= $maxP; ?>"
    data-maxvi="<?= $maxVi; ?>"
    data-maxvs="<?= $maxVs; ?>">
</div>
<form class="_reservation-form" action="facture.php" method="POST">

            <!--Hidden-->
            <input type="hidden" name="id_travers" value="<?php echo "$id_travers"?>">
            <input type="hidden" name="prixA" value="<?php echo "$prixA"?>" >
            <input type="hidden" name="prixJ" value="<?php echo "$prixJ"?>" >
            <input type="hidden" name="prixE" value="<?php echo "$prixE"?>" >
            <input type="hidden" name="prixVi4" value="<?php echo "$prixVi4"?>" >
            <input type="hidden" name="prixVi5" value="<?php echo "$prixVi5"?>" >
            <input type="hidden" name="prixF" value="<?php echo "$prixF"?>" >
            <input type="hidden" name="prixCc" value="<?php echo "$prixCc"?>" >
            <input type="hidden" name="prixC" value="<?php echo "$prixC"?>" >

            <!--input Text-->
            <input type="text" placeholder="Nom*" class="_reservation-input" value ="<?php if ($client==""){echo $nom;}else{echo $client["nom_client"];} ?>">
            <input type="text" name="adresse"placeholder="Adresse*" class="_reservation-input" value ="<?php if ($client==""){echo "";}else{echo $client["adresse_client"];} ?>">
            <input type="text" name="cp" placeholder="Code postal*" class="_reservation-input">
            <input type="text" name="ville" placeholder="Ville*" class="_reservation-input">
            <input type="text" name="tel" placeholder="Numéro de téléphone*" class="_reservation-input" value = "<?php if ($client==""){echo "";}else{echo $client["tel_client"];} ?>">
            <input type="text" name="mail" placeholder="Mail*" class="_reservation-input" value ="<?php if ($client==""){echo "";}else{echo $client["mail_client"];} ?>">
            
        

        <table class="_reservation-table">
            <thead>
                <tr>
                    <th>Catégorie</th>
                    <th>Tarif en €</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Adulte</td>
                    <td><?php echo $prixA ?></td>
                    <td><input type="number" name="nbA" id="nbA"value="" min="0" max="<?php echo $maxP; ?>" class="_reservation-quantity"></td>
                </tr>
                <tr>
                    <td>Junior 8 à 18 ans</td>
                    <td><?php echo $prixJ ?></td>
                    <td><input type="number" name="nbJ" id="nbJ" value="" min="0" max="<?php echo $maxP; ?>" class="_reservation-quantity"></td>
                </tr>
                <tr>
                    <td>Enfant 0 à 7 ans</td>
                    <td><?php echo $prixE ?></td>
                    <td><input type="number" name="nbE" id="nbE" value="" min="0" max="<?php echo $maxP; ?>" class="_reservation-quantity"></td>
                </tr>
                <tr>
                    <td>Voiture long. inf. 4m</td>
                    <td><?php echo $prixVi4 ?></td>
                    <td><input type="number" name="nbVi4" id="nbVi4" value="" min="0" max="<?php echo $maxVi; ?>" class="_reservation-quantity"></td>
                </tr>
                <tr>
                    <td>Voiture long. inf. 5m</td>
                    <td><?php echo $prixVi5 ?></td>
                    <td><input type="number" name="nbVi5" id="nbVi5" value="" min="0" max="<?php echo $maxVi; ?>" class="_reservation-quantity"></td>
                </tr>
                <tr>
                    <td>Fourgon</td>
                    <td><?php echo $prixF ?></td>
                    <td><input type="number" name="nbF" id="nbF" value="" min="0" max="<?php echo $maxVs; ?>" class="_reservation-quantity"></td>
                </tr>
                <tr>
                    <td>Camping Car</td>
                    <td><?php echo $prixCc ?></td>
                    <td><input type="number" name="nbCc" id="nbCc" value="" min="0" max="<?php echo $maxVs; ?>" class="_reservation-quantity"></td>
                </tr>
                <tr>
                    <td>Camion</td>
                    <td><?php echo $prixC ?></td>
                    <td><input type="number" name="nbC" id="nbC" value="" min="0" max="<?php echo $maxVs; ?>" class="_reservation-quantity"></td>
                </tr>
            </tbody>
        </table>
        <button class="_reservation-button" type="submit">Enregistrer la réservation</button>
        </form>
    </div>
    <script src="../JavaScript/scriptReservation.js"></script>
</body>