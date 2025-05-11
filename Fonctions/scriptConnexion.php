<?php
session_start(); // Toujours en premier

// Inclusion de la connexion centralisée
include_once "../pdo/pdo.php";
global $pdo;

function validEmail($email) {
    if (empty(trim($email))) {
        $_SESSION['error'] = "Une adresse e-mail est requise.";
        return false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "L'adresse e-mail n'est pas valide.";
        return false;
    }
    return true;
}

function validPwd($password) {
    if (empty($password)) {
        $_SESSION['error'] = "Un mot de passe est requis.";
        return false;
    }
    return true;
}

function getUserByEmail($connexion, $email) {
    $query = $connexion->prepare("SELECT id_utilisateur, mail_user, mdp_user, typer_user FROM utilisateur WHERE mail_user = :email");
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch();
}

// Vérifie si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($pdo) {
        $email = trim($_POST["email"]);
        $password = $_POST["password"];

        // Vérification des champs
        if (validEmail($email) && validPwd($password)) {
            $user = getUserByEmail($pdo, $email);

            if (!$user) { // L'utilisateur n'existe pas
                $_SESSION['error'] = "Email ou mot de passe incorrect.";
                header("Location: ../Pages/connexion.php");
                exit();
            }

            // Vérification du mot de passe avec password_verify()
            if (password_verify($password, $user['mdp_user'])) {
                session_regenerate_id(true); // Sécurisation de la session
                $_SESSION['user_id'] = $user['id_utilisateur'];
                $_SESSION['typer_user'] = $user['typer_user']; // Stocke le type d'utilisateur

                // Redirection selon le type d'utilisateur
                if ($user['typer_user'] === 'Gestionnaire') {
                    header("Location: ../Pages/accueilAdmin.php"); // Page gestionnaire
                } else {
                    header("Location: ../Pages/index.php"); // Page client
                }
                exit();
            } else {
                $_SESSION['error'] = "Email ou mot de passe incorrect.";
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
