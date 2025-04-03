<?php
// Démarrer la session pour accéder aux variables de session
ob_start();
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    // Paramètres de connexion à la base de données
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "marieteam";

    try {
        // Créer une connexion à la base de données
        $connexion = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);

        // Préparer la requête pour obtenir le prénom et le nom de l'utilisateur
        $query = $connexion->prepare("SELECT prenom_user, nom_user FROM utilisateur WHERE id_utilisateur = :user_id");
        $query->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $query->execute();

        // Récupérer les résultats de la requête
        $user = $query->fetch();
        if ($user) {
            // Stocker le prénom et le nom dans des variables pour les utiliser dans la page
            $prenom = $user['prenom_user'];
            $nom = $user['nom_user'];
        } else {
            // Si l'utilisateur n'est pas trouvé dans la base de données, rediriger vers la page de connexion
            $_SESSION['error'] = "Utilisateur non trouvé.";
            header("Location: ../Pages/connexion.php");
            exit();
        }
    } catch (PDOException $e) {
        // Si une erreur se produit lors de la connexion à la base de données
        $_SESSION['error'] = "Erreur de connexion à la base de données : " . $e->getMessage();
        header("Location: ../Pages/connexion.php");
        exit();
    }
} else {
    // L'utilisateur n'est pas connecté, donc on laisse $prenom et $nom à null
    $prenom = null;
    $nom = null;
}
?>
