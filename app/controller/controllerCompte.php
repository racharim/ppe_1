<?php
require_once __DIR__ . '/../modele/participe.php';
require_once __DIR__ . '/../modele/match.php';
require_once __DIR__ . '/../modele/favoris.php';
require_once __DIR__ . '/../modele/joueur.php';
require_once __DIR__ . '/../modele/sport.php';
require_once __DIR__ . '/../modele/admin.php';
require_once __DIR__ . '/../modele/coach.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: /ppe_1/public/index.php?page=connexion');
    exit();
}

$uid = $_SESSION['utilisateur_id'];

$participeModele = new participeModele();
$matchModele = new matchModele();
$favorisModele = new favorisModele();
$sports = new sportModele();

if($_SESSION['utilisateur_type'] == 1){

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
                if($favorisModele->isFavoris($idJoueur, $idSport)){
                    // Le sport est déjà dans les favoris, vous pouvez choisir de le supprimer ou de ne rien faire
                    // Par exemple, pour le supprimer :
                    $favorisModele->removeFavoris($idJoueur, $idSport);
                } else {
                    // Ajouter le sport aux favoris
                    $favorisModele->addFavoris($idJoueur, $idSport);
                }
                header('Location: /ppe_1/public/index.php?page=compte');
                exit();
            }
        }
    }
} elseif($_SESSION['utilisateur_type'] == 3){

}
    
require_once __DIR__ . '/../vue/compte.php';
