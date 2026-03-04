<?php
require_once __DIR__ . '/../modele/joueur.php';
require_once __DIR__ . '/../modele/participe.php';
require_once __DIR__ . '/../modele/match.php';
require_once __DIR__ . '/../modele/favoris.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['utilisateur_id'])) {
    // demander connexion via front controller
    header('Location: /ppe_1/public/index.php?page=connexion');
    exit();
}

$uid = $_SESSION['utilisateur_id'];

// Récupérer les matchs auxquels l'utilisateur participe
$participeModele = new participeModele();
$matchModele = new matchModele();
$favorisModele = new favorisModele();

$matchs = [];
$matchsRecommandes = [];

// Récupérer les participations de l'utilisateur (joueur)
if (isset($_SESSION['joueur'])) {
    $joueur = $_SESSION['joueur'];
    $idJoueur = $joueur->getIdJoueur();
    
    // Matchs auxquels il participe
    $participation = $participeModele->getAllByJoueurID($idJoueur);
    if ($participation) {
        foreach ($participation as $part) {
            $match = $matchModele->getMatchId($part['id_match']);
            if ($match) {
                $matchs[] = $match; 
            }
        }
    }
    
    // Matchs recommandés basés sur les sports favoris
    $matchsRecommandes = $matchModele->getMatchByFav($idJoueur);
    if (!$matchsRecommandes) {
        $matchsRecommandes = [];
    }

    // Gestion des inscriptions et désinscriptions
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] === 'inscrire' && isset($_POST['id_match'])) {
            $participeModele->addParticipation($idJoueur, (int)$_POST['id_match']);
            header('Location: /ppe_1/public/index.php?page=accueil');
            exit();
        } elseif ($_POST['action'] === 'desinscrire' && isset($_POST['id_match'])) {
            $participeModele->removeParticipation($idJoueur, (int)$_POST['id_match']);
            header('Location: /ppe_1/public/index.php?page=accueil');
            exit();
        }
    }
}
require_once __DIR__ . '/../vue/accueil.php';
