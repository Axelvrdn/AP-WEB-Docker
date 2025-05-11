<?php
session_start();

// Inclusion de la connexion centralisée
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
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{12,}$/", $password)){
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

function insertUser ($connexion, $nom, $prenom, $email, $password) {
    $pwdHach = password_hash($password, PASSWORD_DEFAULT);

    $monObjPdoStatement = $connexion->prepare("INSERT INTO Utilisateur (nom_user, prenom_user, mail_user, mdp_user, typer_user) VALUES (:nom, :prenom, :mail, :mdp, 'Client')"); 
    $monObjPdoStatement->bindValue(':nom', $nom, PDO::PARAM_STR);
    $monObjPdoStatement->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $monObjPdoStatement->bindValue(':mail', $email, PDO::PARAM_STR);
    $monObjPdoStatement->bindValue(':mdp', $pwdHach, PDO::PARAM_STR);
    
    $monObjPdoStatement->execute();
}

if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    if ($pdo) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $validNom = validNom($nom);
        $validPrenom = validPrenom($prenom);
        $validEmail = validEmail($email);
        $validPwd = validPwd($password);

        if ($validNom && $validPrenom && $validEmail && $validPwd) {
            if (!ifExistEmail($pdo, $email)) {
                insertUser($pdo, $nom, $prenom, $email, $password);

                // Redirection après inscription
                header("Location: ../Pages/connexion.php");
                exit();
            } else {
                $_SESSION['error'] = "Cette adresse email est déjà utilisée.";
                header("Location: ../Pages/connexion.php");
                exit();
            }
        } else {
            header("Location: ../Pages/connexion.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "La connexion à la base de données a échoué.";
        header("Location: ../Pages/connexion.php");
        exit();
    }
}
?>
