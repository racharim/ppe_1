<?php
require_once '../../app/modele/participe.php';
require_once '../../app/modele/match.php';
require_once '../../app/modele/favoris.php';
require_once '../../app/modele/joueur.php';
require_once '../../app/modele/sport.php';
require_once '../../app/modele/admin.php';    
require_once '../../app/modele/coach.php';    

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
$sports = new sportModele();

$matchs = [];
$sportsFavoris = [];
$matchsRecommandes = [];
$listeSport =[];

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
    //liste de tout les sport
    $listeSport= $sports->getAllSports();

    // Matchs recommandés basés sur les sports favoris
    $favoris = $favorisModele->getfavorisById($idJoueur);
    if($favoris){
        foreach ($favoris as $fav){
            $sportsFavoris[] = $sports->getSportById($fav['id_sport']);
        }
    }
    

    //modification du compte selon les données du formulaire
    if(!empty($_POST)){
    $joueur->setNom($_POST['nom']);
    $joueur->setPrenom($_POST['prenom']);
    $joueur->setTel($_POST['tel']);
    $joueur->setMail($_POST['mail']);

    $joueur->updateJoueur();

    if(isset($_POST['sport'])){
        $idSport = $_POST['sport'];
        $favorisModele->addFavoris($idJoueur, $idSport);
        header('Location: /ppe_1/app/controller/controllerCompte');
        exit();
    }
}
}
    
require_once '../../app/vue/compte.php';
