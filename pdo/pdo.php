<?php

function connexionBase($servername, $username, $password, $dbname) {
    try {
        return new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        return null;
    }
}

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "marieteam";

$pdo = connexionBase($servername, $username, $password, $dbname);
?>