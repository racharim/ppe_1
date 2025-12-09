<?php
require_once '../../app/modele/joueur.php';
require_once '../../app/modele/participe.php';
require_once '../../app/modele/match.php';
require_once '../../app/modele/favoris.php';

session_start();

if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: /ppe_1/app/vue/connexion.php');
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
