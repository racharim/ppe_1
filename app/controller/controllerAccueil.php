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
    $favoris = $favorisModele->getfavorisById($idJoueur);
    if ($favoris) {
        foreach ($favoris as $fav) {
            $matchRec = $matchModele->getMatchByFav($idJoueur);
            if ($matchRec && !in_array($matchRec, $matchsRecommandes)) {
                $matchsRecommandes[] = $matchRec;
            }
        }
    }
}
require_once __DIR__ . '/../vue/accueil.php';
