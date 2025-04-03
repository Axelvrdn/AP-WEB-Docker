<?php
include '../Fonctions/scriptReserver.php';

if (isset($_GET['desc_travers'])) {
    $desc_travers = $_GET['desc_travers'];
    $dates = GetDateTravers($desc_travers);
    
    echo json_encode($dates);
}
?>