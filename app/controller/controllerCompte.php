<?php
require_once __DIR__ . '/../modele/participe.php';
require_once __DIR__ . '/../modele/match.php';
require_once __DIR__ . '/../modele/favoris.php';
require_once __DIR__ . '/../modele/joueur.php';
require_once __DIR__ . '/../modele/sport.php';
require_once __DIR__ . '/../modele/admin.php';
require_once __DIR__ . '/../modele/coach.php';
require_once __DIR__ . '/../modele/lieu.php';
require_once __DIR__ . '/../modele/utilisateur.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['utilisateur']) || !($_SESSION['utilisateur'] instanceof UtilisateurModele)) {
    header('Location: /ppe_1/public/index.php?page=connexion');
    exit();
}
$utilisateurSession = $_SESSION['utilisateur'];

$participeModele = new participeModele();
$matchModele = new matchModele();
$favorisModele = new favorisModele();
$sports = new sportModele();
$lieuModele = new lieuModele();

$messageSucces = '';

// Récupérer le message de succès de la session s'il existe
if(isset($_SESSION['messageSucces'])){
    $messageSucces = $_SESSION['messageSucces'];
    unset($_SESSION['messageSucces']); // Nettoyer après affichage
}

if($utilisateurSession->getTypeCompte() == 1){

    $matchs = [];
    $sportsFavoris = [];
    $matchsRecommandes = [];
    $listeSport =[];

    if (isset($_SESSION['joueur'])) {
        $joueur = $_SESSION['joueur'];
        $utilisateur = $_SESSION['utilisateur'];
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
        if(isset($_POST['action']) && $_POST['action'] === 'update_profil'){
            // Mettre à jour uniquement les champs fournis
            if(isset($_POST['nom']) && !empty($_POST['nom'])){
                $utilisateur->setNom($_POST['nom']);
            }
            if(isset($_POST['prenom']) && !empty($_POST['prenom'])){
                $utilisateur->setPrenom($_POST['prenom']);
            }
            if(isset($_POST['tel']) && !empty($_POST['tel'])){
                $joueur->setTel($_POST['tel']);
            }
            if(isset($_POST['mail']) && !empty($_POST['mail'])){
                $joueur->setMail($_POST['mail']);
            }

            $utilisateur->updateUtilisateur();
            $joueur->updateJoueur();
            header('Location: /ppe_1/public/index.php?page=compte');
            exit();
        }
        
        if(isset($_POST['sport'])){
                $idSport = $_POST['sport'];
                if($favorisModele->isFavoris($idJoueur, $idSport)){
                    // Le sport est déjà dans les favoris, vous pouvez choisir de le supprimer ou de ne rien faire
                    // Par exemple, pour le supprimer :
                    $favorisModele->removeFavoris($idJoueur, $idSport);
                    $_SESSION['messageSucces'] = "Sport retiré de vos favoris !";
                } else {
                    // Ajouter le sport aux favoris
                    $favorisModele->addFavoris($idJoueur, $idSport);
                    $_SESSION['messageSucces'] = "Sport ajouté à vos favoris !";
                }
                header('Location: /ppe_1/public/index.php?page=compte');
                exit();
            }
    }
} elseif($utilisateurSession->getTypeCompte() == 2){
    if (!isset($_SESSION['coach'])) {
        // Au cas où la session n'est pas bien initialisée
        $_SESSION['coach'] = new coachModele($utilisateurSession->getId());
    }
    $coach = $_SESSION['coach'];
    $idSportCoach = $coach->getIdSport();
    $nomSportCoach = $coach->getSport();

    if(isset($_POST['action'])) {
        if($_POST['action'] === 'update_profil_coach'){
            if(isset($_POST['nom']) && !empty($_POST['nom'])){
                $utilisateurSession->setNom($_POST['nom']);
            }
            if(isset($_POST['prenom']) && !empty($_POST['prenom'])){
                $utilisateurSession->setPrenom($_POST['prenom']);
            }
            $utilisateurSession->updateUtilisateur();
            $_SESSION['messageSucces'] = "Profil mis à jour !";
            header('Location: /ppe_1/public/index.php?page=compte');
            exit();
        }

        if ($_POST['action'] === 'add_match_coach') {
            $matchModele->addMatch(
                $_POST['libelle'],
                $_POST['descriptif'],
                $_POST['date_debut'],
                $_POST['date_fin'],
                $_POST['id_niv'],
                $idSportCoach, // Le coach ne peut créer que des matchs de son sport
                $_POST['id_lieu']
            );
            $_SESSION['messageSucces'] = "Le match a bien été créé !";
            header('Location: /ppe_1/public/index.php?page=compte');
            exit();
        }
    }

    $listeLieu = $lieuModele->getAllLieux();
    
} elseif($utilisateurSession->getTypeCompte() == 3){
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_sport') {
        $nom = $_POST['nom_sport'];
        $n_joueur = (int)$_POST['n_joueur'];
        $desc = $_POST['descriptif'];
        
        $sports->addSport($nom, $n_joueur, $desc);
        
        // Redirection pour éviter de renvoyer le formulaire en actualisant
        header('Location: /ppe_1/public/index.php?page=compte');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_joueur') {
        // 1. Créer l'utilisateur d'abord (pour avoir l'ID)
        $login = $_POST['login'];
        $mdp = $_POST['mdp']; // Idéalement, haché avec password_hash()
        
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $nouvelUtil = new UtilisateurModele($login, $mdp);
        $nouvelUtil->setNom($nom);
        $nouvelUtil->setPrenom($prenom);
        $nouvelUtil->setTypeCompte(1);
        $nouvelUtil->AjouterUtilisateur();
        $idUtilisateur = $nouvelUtil->getLastIdUtilisateur(); // Récupère l'ID qui vient d'être créé

        // 2. Créer le joueur lié à cet utilisateur
        $tel = $_POST['tel'];
        $mail = $_POST['mail'];
        $idNiveau = (int)$_POST['id_niv'];

        $joueurModele = new joueurModele($tel, $mail, $idNiveau, $idUtilisateur);
        $joueurModele->createJoueur($joueurModele);

        header('Location: /ppe_1/public/index.php?page=compte');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_coach') {
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];
        
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        
        $nouvelUtil = new UtilisateurModele($login, $mdp);
        $nouvelUtil->setNom($nom);
        $nouvelUtil->setPrenom($prenom);
        $nouvelUtil->setTypeCompte(2); // 2 = Coach
        $nouvelUtil->AjouterUtilisateur();
        $idUtilisateur = $nouvelUtil->getLastIdUtilisateur();

        $idSport = (int)$_POST['id_sport'];
        $sportData = $sports->getSportById($idSport);
        $nomSport = $sportData ? $sportData['nom'] : '';

        $monCoach = new coachModele($idUtilisateur);
        $monCoach->setNom($nom);
        $monCoach->setPrenom($prenom);
        $monCoach->setIdSport($idSport);
        $monCoach->setSport($nomSport);
        $monCoach->createCoach();

        header('Location: /ppe_1/public/index.php?page=compte');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_admin') {
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];
        
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        
        $nouvelUtil = new UtilisateurModele($login, $mdp);
        $nouvelUtil->setNom($nom);
        $nouvelUtil->setPrenom($prenom);
        $nouvelUtil->setTypeCompte(3); // 3 = Admin
        $nouvelUtil->AjouterUtilisateur();

        $_SESSION['messageSucces'] = "Compte Administrateur créé avec succès !";
        header('Location: /ppe_1/public/index.php?page=compte');
        exit();
    }

    $listeSport = $sports->getAllSports(); // Pour le formulaire de match
    $listeLieu = $lieuModele->getAllLieux(); // Pour le formulaire de match

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] === 'add_match') {
            $matchModele->addMatch(
                $_POST['libelle'],
                $_POST['descriptif'],
                $_POST['date_debut'],
                $_POST['date_fin'],
                $_POST['id_niv'],
                $_POST['id_sport'],
                $_POST['id_lieu']
            );
            $_SESSION['messageSucces'] = "Match créé avec succès !";
            header('Location: /ppe_1/public/index.php?page=compte');
            exit();
        }
        
        if ($_POST['action'] === 'delete_joueur') {
            $idToDelete = (int)$_POST['id_utilisateur'];
            $utilisateurSession->deleteJoueurComplet($idToDelete);
            $_SESSION['messageSucces'] = "Joueur supprimé avec succès !";
            header('Location: /ppe_1/public/index.php?page=compte');
            exit();
        }

        if ($_POST['action'] === 'delete_coach') {
            $idToDelete = (int)$_POST['id_utilisateur'];
            $utilisateurSession->deleteCoachComplet($idToDelete);
            $_SESSION['messageSucces'] = "Coach supprimé avec succès !";
            header('Location: /ppe_1/public/index.php?page=compte');
            exit();
        }
    }

    // Récupérer les listes pour les select de suppression
    $tousLesJoueurs = $utilisateurSession->getAllJoueurs();
    $tousLesCoachs = $utilisateurSession->getAllCoachs();

}
    
require_once __DIR__ . '/../vue/compte.php';
