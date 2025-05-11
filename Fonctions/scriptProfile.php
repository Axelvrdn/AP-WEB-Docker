<?php

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color: red;'>Vous devez être connecté pour modifier vos informations.</p>";
    exit();
}

// Inclusion de la connexion PDO centralisée
include_once "../pdo/pdo.php";
global $pdo;

function validNom($nom) {
    if (trim(htmlspecialchars($nom)) == "") {
        echo "<p style='color: red;'>Un nom est requis.</p>";
        return false;
    } else {
        if (!preg_match("/^[a-zA-Z]+$/", $nom)) {
            echo "<p style='color: red;'>Le nom doit contenir seulement des lettres.</p>";
            return false;
        }
    }
    return true;
}

function validPrenom($prenom) {
    if (trim(htmlspecialchars($prenom)) == "") {
        echo "<p style='color: red;'>Un prénom est requis.</p>";
        return false;
    } else {
        if (!preg_match("/^[a-zA-Z]+$/", $prenom)) {
            echo "<p style='color: red;'>Le prénom doit contenir seulement des lettres.</p>";
            return false;
        }
    }
    return true;
}

function validEmail($email) {
    if (trim(htmlspecialchars($email)) == "") {
        echo "<p style='color: red;'>Une adresse e-mail est requise.</p>";
        return false;
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p style='color: red;'>L'adresse e-mail n'est pas valide.</p>";
            return false;
        }
    }
    return true;
}

function validPwd($password) {
    if (trim(htmlspecialchars($password)) == "") {
        echo "<p style='color: red;'>Un mot de passe est requis.</p>";
        return false;
    } else {
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{12,}$/", $password)) {
            echo "<p style='color: red;'>Le mot de passe doit faire au moins 12 caractères et contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial.</p>";
            return false;
        }
    }
    return true;
}

function ifExistEmail($connexion, $email) {
    $emailExist = $connexion->prepare("SELECT COUNT(*) as nbemail FROM Utilisateur WHERE mail_user = :email");
    $emailExist->bindValue(':email', $email, PDO::PARAM_STR);
    $emailExist->execute();
    $laLigne = $emailExist->fetch();
    return $laLigne['nbemail'] > 0;
}

function updateUser($connexion, $idUtilisateur, $nom, $prenom, $email, $password) {
    $pwdHach = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE utilisateur SET nom_user = :nom, prenom_user = :prenom, mail_user = :email, mdp_user = :pwdHach WHERE id_utilisateur = :id";
    $params = [
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':pwdHach' => $pwdHach,
        ':id' => $idUtilisateur
    ];
    
    $stmt = $connexion->prepare($query);
    return $stmt->execute($params);
}

// Récupération des données du formulaire
if (isset($_POST["nom"], $_POST["prenom"], $_POST["email"], $_POST["password"])) {
    if ($pdo) {
        $idUtilisateur = $_SESSION['user_id'];
        $nom = trim($_POST["nom"]);
        $prenom = trim($_POST["prenom"]);
        $email = trim($_POST["email"]);
        $newPassword = trim($_POST["password"]);

        // Validation des entrées
        $validNom = validNom($nom);
        $validPrenom = validPrenom($prenom);
        $validEmail = validEmail($email);
        $validPwd = validPwd($newPassword);

        if ($validNom && $validPrenom && $validEmail && $validPwd) {
            if (!ifExistEmail($pdo, $email) || $email === $_SESSION['email']) {
                updateUser($pdo, $idUtilisateur, $nom, $prenom, $email, $newPassword);
                $_SESSION['messageUpdate'] = "Informations mises à jour avec succès!";
            } else {
                $_SESSION['errorUpdate'] = "Cette adresse e-mail est déjà utilisée.";
            }
        }
    }
}
?>
