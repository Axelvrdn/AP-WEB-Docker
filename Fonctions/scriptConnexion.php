<?php
session_start(); // Toujours en premier

function connexionBase($servername, $username, $password, $dbname) {
    try {
        return new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    } catch (PDOException $e) {
        $_SESSION['error'] = "Impossible de se connecter à la base de données. Veuillez réessayer plus tard.";
        header("Location: ../Pages/connexion.php");
        exit();
    }
}

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
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "marieteam";

    $connexion = connexionBase($servername, $username, $password, $dbname);

    if ($connexion) {
        $email = trim($_POST["email"]);
        $password = $_POST["password"];

        // Vérification des champs
        if (validEmail($email) && validPwd($password)) {
            $user = getUserByEmail($connexion, $email);

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
                header("../Pages/connexion.php");
                exit();
            }
        } else {
            header("../Pages/connexion.php");
            exit();
        }
    }
}
?>
