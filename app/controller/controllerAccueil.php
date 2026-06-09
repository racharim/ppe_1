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

$messageSucces = '';
if (isset($_SESSION['messageSucces'])) {
    $messageSucces = $_SESSION['messageSucces'];
    unset($_SESSION['messageSucces']);
}

$messageErreur = '';
if (isset($_SESSION['messageErreur'])) {
    $messageErreur = $_SESSION['messageErreur'];
    unset($_SESSION['messageErreur']);
}

// Récupérer les participations de l'utilisateur (joueur)
if (isset($_SESSION['joueur']) && $_SESSION['utilisateur']->getTypeCompte() == 1) {
    $joueur = $_SESSION['joueur'];
    $idJoueur = $joueur->getIdJoueur();

    // 3 prochains matchs à venir avec sport et adresse du lieu
    $now = date('Y-m-d H:i:s');
    $matchs = $matchModele->getNextMatchsByJoueurWithSportAndLieu($idJoueur, $now, 3);
    
    // Matchs recommandés basés sur les sports favoris
    $matchsRecommandes = $matchModele->getMatchByFav($idJoueur);
    if ($matchsRecommandes) {
        $matchsRecommandes = array_values(array_filter($matchsRecommandes, function($matchRec) use ($now) {
            return isset($matchRec['date_debut']) && $matchRec['date_debut'] >= $now;
        }));

        usort($matchsRecommandes, function($a, $b) {
            return strtotime($a['date_debut']) - strtotime($b['date_debut']);
        });
    } else {
        $matchsRecommandes = [];
    }

    // Gestion des inscriptions et désinscriptions
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] === 'inscrire' && isset($_POST['id_match'])) {
            $idMatch = (int)$_POST['id_match'];

            if ($participeModele->isParticipating($idJoueur, $idMatch)) {
                $_SESSION['messageErreur'] = "Inscription refusée : vous êtes déjà inscrit à ce match.";
                header('Location: /ppe_1/public/index.php?page=accueil');
                exit();
            }

            $capaciteMax = $participeModele->getMatchCapacity($idMatch);
            $nbInscrits = $participeModele->getParticipantCountByMatchId($idMatch);

            if ($capaciteMax > 0 && $nbInscrits >= $capaciteMax) {
                $_SESSION['messageErreur'] = "Inscription refusée : le match est complet (" . $nbInscrits . "/" . $capaciteMax . ").";
                header('Location: /ppe_1/public/index.php?page=accueil');
                exit();
            }

            $participeModele->addParticipation($idJoueur, $idMatch);
            $_SESSION['messageSucces'] = "Inscription confirmée au match.";
            header('Location: /ppe_1/public/index.php?page=accueil');
            exit();
        } elseif ($_POST['action'] === 'desinscrire' && isset($_POST['id_match'])) {
            $participeModele->removeParticipation($idJoueur, (int)$_POST['id_match']);
            $_SESSION['messageSucces'] = "Désinscription effectuée.";
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
