<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../modele/sport.php';

if (!isset($_SESSION['utilisateur']) || !($_SESSION['utilisateur'] instanceof UtilisateurModele)) {
    header('Location: /ppe_1/public/index.php?page=connexion');
    exit();
}

$sportModele = new SportModele();
$statsParticipation = $sportModele->getStatsParticipationParSport();

require_once __DIR__ . '/../vue/stats_participation.php';
