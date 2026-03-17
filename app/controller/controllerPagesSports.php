<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../modele/sport.php';
require_once __DIR__ . '/../modele/favoris.php';
require_once __DIR__ . '/../modele/joueur.php';

if (!isset($_SESSION['utilisateur']) || !($_SESSION['utilisateur'] instanceof UtilisateurModele)) {
    // demander connexion via front controller
    header('Location: /ppe_1/public/index.php?page=connexion');
    exit();
}

$SportModele = new SportModele();
$favorisModele = new favorisModele();

$sports = [];
$sports = $SportModele->getAllSports();

// Récupérer le joueur de la session
$joueur = $_SESSION['joueur'] ?? null;
$idJoueur = $joueur ? $joueur->getIdJoueur() : 0;

// Récupérer les sports favoris du joueur
$mesFavoris = [];
if ($idJoueur > 0) {
    $favoris = $favorisModele->getfavorisById($idJoueur);
    if ($favoris) {
        foreach ($favoris as $fav) {
            $mesFavoris[] = $fav['id_sport'];
        }
    }
}

$messageSucces = '';
if(isset($_SESSION['messageSucces'])){
    $messageSucces = $_SESSION['messageSucces'];
    unset($_SESSION['messageSucces']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['id_sport']) && $idJoueur > 0) {
        $idSport = (int)$_POST['id_sport'];
        
        if ($_POST['action'] === 'inscrire') {
            if (!$favorisModele->isFavoris($idJoueur, $idSport)) {
                $favorisModele->addFavoris($idJoueur, $idSport);
                $_SESSION['messageSucces'] = "Sport ajouté à vos favoris !";
            }
        } elseif ($_POST['action'] === 'desinscrire') {
            $favorisModele->removeFavoris($idJoueur, $idSport);
            $_SESSION['messageSucces'] = "Sport retiré de vos favoris.";
        }
        
        header('Location: /ppe_1/public/index.php?page=pagesSports');
        exit();
    }
}


require_once __DIR__ . '/../vue/pageSports.php';
