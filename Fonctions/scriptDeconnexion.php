<?php
session_start(); // Démarrer la session

// Récupérer les paramètres du cookie de session
$params = session_get_cookie_params();

// Supprimer toutes les variables de session
$_SESSION = [];

// Détruire la session côté serveur
session_unset();
session_destroy();

// Supprimer explicitement le cookie de session
setcookie(session_name(), '', time() - 42000, 
    $params['path'] ?? '/', 
    $params['domain'] ?? '', 
    $params['secure'] ?? false, 
    $params['httponly'] ?? false
);

// Supprimer aussi directement PHPSESSID pour éviter toute persistance
setcookie("PHPSESSID", "", time() - 42000, "/", "", false, true);

// **Forcer la suppression en vérifiant après**
if (isset($_COOKIE['PHPSESSID'])) {
    unset($_COOKIE['PHPSESSID']); // Supprimer la variable côté PHP
}

// Redirection vers la page d'accueil après suppression
header("Location: ../Pages/index.php");
exit();
