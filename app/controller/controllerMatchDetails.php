<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../modele/match.php';

// Vérifier si l'utilisateur est authentifié (Optionnel mais recommandé)
if (!isset($_SESSION['utilisateur'])) {
    header('Location: /ppe_1/public/index.php?page=connexion');
    exit();
}

$matchModele = new matchModele();

// Vérifier si l'utilisateur est autorisé à modifier (Coach = 2, Admin = 3)
$isAuthorizedToEdit = isset($_SESSION['utilisateur']) && in_array((int)$_SESSION['utilisateur']->getTypeCompte(), [2, 3]);

// Gérer la mise à jour du match si admin ou coach
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_match' && $isAuthorizedToEdit) {
    $id_match = (int)$_POST['id_match'];
    $libelle = trim($_POST['libelle']);
    $descriptif = trim($_POST['descriptif']);
    // L'entrée datetime-local envoie le format YYYY-MM-DDTHH:MM, nous le convertissons en datetime MySQL
    $date_debut = str_replace('T', ' ', $_POST['date_debut']) . ':00';
    $date_fin = str_replace('T', ' ', $_POST['date_fin']) . ':00';
    
    $matchModele->updateMatch($id_match, $libelle, $descriptif, $date_debut, $date_fin);
    
    header("Location: /ppe_1/public/index.php?page=match_details&id=$id_match&success=1");
    exit();
}

$matchDetails = null;

if (isset($_GET['id'])) {
    $id_match = (int)$_GET['id'];
    $matchDetails = $matchModele->getMatchDetails($id_match);
}

// Rediriger si aucun match n'a été trouvé
if (!$matchDetails) {
    header('Location: /ppe_1/public/index.php?page=accueil');
    exit();
}

// Formater les dates pour l'affichage
$dateDebut = date('d/m/Y H:i', strtotime($matchDetails['date_debut']));
$dateFin = date('d/m/Y H:i', strtotime($matchDetails['date_fin']));

require_once __DIR__ . '/../vue/match_details.php';
