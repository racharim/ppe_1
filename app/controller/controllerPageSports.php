<?php 

session_start();

require_once '../../app/modele/sport.php';

if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: /ppe_1/app/vue/connexion.php');
    exit();
}

$SportModele = new SportModele();

$sports = [];
$sports = $SportModele->getAllSports();

require_once '../vue/pageSports.php';
