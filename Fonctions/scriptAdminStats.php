<?php
// Connexion à la base de données
include_once "../pdo/pdo.php";
global $pdo;

// Initialisation des variables
$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';
$stats = null;

// Récupération des statistiques si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $startDate && $endDate) {
    // Requête pour le chiffre d'affaires
    $revenueQuery = "
        SELECT SUM(t.Tarif * e.quantité) AS total_revenue
        FROM reservation r
        JOIN liaison l ON r.id_travers = l.id_travers
        JOIN enregistrer e ON r.id_resa = e.id_resa
        JOIN tarifer t ON l.id_liaison = t.id_liaison AND e.id_type = t.id_type
        WHERE r.date_resa BETWEEN :startDate AND :endDate;
    ";
    
    // Requête pour les passagers par catégorie
    $passengersQuery = "
        SELECT 
            t.desc_type,
            SUM(e.quantité) as total
        FROM reservation r
        JOIN enregistrer e ON r.id_resa = e.id_resa
        JOIN type t ON e.id_type = t.id_type
        WHERE r.date_resa BETWEEN :startDate AND :endDate
        GROUP BY t.desc_type
    ";

    try {
        // Exécution des requêtes
        $stmt = $pdo->prepare($revenueQuery);
        $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);
        $revenue = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;

        $stmt = $pdo->prepare($passengersQuery);
        $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);
        $passengersByType = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Organisation des données
        $stats = [
            'revenue' => $revenue,
            'passengers' => $passengersByType
        ];
    } catch(PDOException $e) {
        echo "Erreur de requête : " . $e->getMessage();
        exit();
    }
}
?>