<?php
require_once __DIR__ . '/../modele/joueur.php';
require_once __DIR__ . '/../modele/participe.php';
require_once __DIR__ . '/../modele/match.php';
require_once __DIR__ . '/../modele/favoris.php';
require_once __DIR__ . '/../modele/coach.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['utilisateur']) || !($_SESSION['utilisateur'] instanceof UtilisateurModele)) {
    // demander connexion via front controller
    header('Location: /ppe_1/public/index.php?page=connexion');
    exit();
}

// Récupérer les matchs auxquels l'utilisateur participe
$participeModele = new participeModele();
$matchModele = new matchModele();
$favorisModele = new favorisModele();

$matchs = [];
$matchsRecommandes = [];

// Récupérer les participations de l'utilisateur (joueur)
if (isset($_SESSION['joueur']) && $_SESSION['utilisateur']->getTypeCompte() == 1) {
    $joueur = $_SESSION['joueur'];
    $idJoueur = $joueur->getIdJoueur();
    
    // Matchs auxquels il participe
    $participation = $participeModele->getAllByJoueurID($idJoueur);
    $tousLesMatchs = [];
    if ($participation) {
        foreach ($participation as $part) {
            $match = $matchModele->getMatchId($part['id_match']);
            if ($match) {
                $tousLesMatchs[] = $match; 
            }
        }
    }
    
    // Garder seulement les matchs futurs et trier par date chronologique
    $now = date('Y-m-d H:i:s');
    $upcomingMatchs = [];
    foreach ($tousLesMatchs as $m) {
        if ($m['date_debut'] >= $now) {
            $upcomingMatchs[] = $m;
        }
    }
    
    usort($upcomingMatchs, function($a, $b) {
        return strtotime($a['date_debut']) - strtotime($b['date_debut']);
    });
    
    // On ne garde que les 3 prochains
    $matchs = array_slice($upcomingMatchs, 0, 3);
    
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
} elseif (isset($_SESSION['coach']) && $_SESSION['utilisateur']->getTypeCompte() == 2) {
    $coach = $_SESSION['coach'];
    $idSportCoach = $coach->getIdSport();
    $matchsCoach = $matchModele->getMatchsBySport($idSportCoach);
} elseif ($_SESSION['utilisateur']->getTypeCompte() == 3) {
    require_once __DIR__ . '/../modele/sport.php';
    $sportModeleAdmin = new SportModele();
    $statsSports = $sportModeleAdmin->getStatsJoueursParSport();
    
    $joueurModeleAdmin = new joueurModele('', '', 0, 0);
    $totalJoueurs = $joueurModeleAdmin->getTotalJoueurs();

    $matchsParMois = $matchModele->getMatchesParMois();
    
    // Obtenir les 5 joueurs inactifs depuis le plus longtemps
    $utilAdmin = new UtilisateurModele('', '');
    $oldestPlayers = $utilAdmin->getOldestConnectedPlayers();
}
require_once __DIR__ . '/../vue/accueil.php';
