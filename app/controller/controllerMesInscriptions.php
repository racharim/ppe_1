<?php
require_once __DIR__ . '/../modele/joueur.php';
require_once __DIR__ . '/../modele/participe.php';
require_once __DIR__ . '/../modele/match.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['utilisateur']) || !($_SESSION['utilisateur'] instanceof UtilisateurModele)) {
    // demander connexion via front controller
    header('Location: /ppe_1/public/index.php?page=connexion');
    exit();
}

if (!isset($_SESSION['joueur']) || $_SESSION['utilisateur']->getTypeCompte() != 1) {
    header('Location: /ppe_1/public/index.php?page=accueil');
    exit();
}

$joueur = $_SESSION['joueur'];
$idJoueur = $joueur->getIdJoueur();

$participeModele = new participeModele();
$matchModele = new matchModele();

// Gestion de la désinscription
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'desinscrire' && isset($_POST['id_match'])) {
        $participeModele->removeParticipation($idJoueur, (int)$_POST['id_match']);
        header('Location: /ppe_1/public/index.php?page=mes_inscriptions');
        exit();
    }
}

// Matchs auxquels il participe
$matchs = [];
$participation = $participeModele->getAllByJoueurID($idJoueur);
if ($participation) {
    foreach ($participation as $part) {
        $match = $matchModele->getMatchId($part['id_match']);
        if ($match) {
            $matchs[] = $match; 
        }
    }
}

// Trier par date pour l'affichage (les plus proches en premier)
usort($matchs, function($a, $b) {
    return strtotime($a['date_debut']) - strtotime($b['date_debut']);
});

require_once __DIR__ . '/../vue/mes_inscriptions.php';
