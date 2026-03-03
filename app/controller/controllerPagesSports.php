<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../modele/sport.php';

if (!isset($_SESSION['utilisateur_id'])) {
    // demander connexion via front controller
    header('Location: /ppe_1/public/index.php?page=connexion');
    exit();
}

$SportModele = new SportModele();

$sports = [];
$sports = $SportModele->getAllSports();

require_once __DIR__ . '/../vue/pageSports.php';
